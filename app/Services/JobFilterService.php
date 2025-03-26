<?php

namespace App\Services;

use App\Models\Job;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class JobFilterService
{
    private Builder $query;
    private array $params;

    /**
     * Constructor to initialize the service with request parameters.
     *
     * @param array $params Request parameters.
     */
    public function __construct(array $params)
    {
        $this->params = $params;
        $this->query = Job::query()->with([
            'languages', 
            'locations', 
            'categories', 
            'attributeValues.attribute'
        ]);
    }

    /**
     * Apply filters and return the query.
     *
     * @return Builder
     */
    public function apply(): Builder
    {
        if (isset($this->params['filter'])) {
            $this->parseFilter($this->params['filter']);
        }
        return $this->query;
    }

    /**
     * Parse the filter string.
     *
     * @param string $filter
     * @return void
     */
    private function parseFilter(string $filter): void
    {
        $filter = trim($filter);
        // Handle grouped conditions
        if (Str::startsWith($filter, '(') && Str::endsWith($filter, ')')) {
            $this->parseGroup(substr($filter, 1, -1));
            return;
        }
        // Handle single condition
        $this->parseCondition($filter);
    }

    /**
     * Parse a group of conditions.
     *
     * @param string $group
     * @return void
     */
    private function parseGroup(string $group): void
    {
        $parts = $this->splitConditions($group);
        if (count($parts) === 1) {
            $this->parseFilter($parts[0]);
            return;
        }
        $this->query->where(function (Builder $query) use ($parts) {
            $this->applyGroup($query, $parts);
        });
    }

    /**
     * Apply a group of conditions to the query.
     *
     * @param Builder $query
     * @param array $parts
     * @return void
     */
    private function applyGroup(Builder $query, array $parts): void
    {
        $conditions = [];
        $logicalOperators = [];
        foreach ($parts as $part) {
            if (in_array($part, ['AND', 'OR'])) {
                $logicalOperators[] = $part;
            } else {
                $conditions[] = $part;
            }
        }
        if (empty($conditions)) return;

        // Apply first condition
        $this->applyConditionToQuery($query, $conditions[0], 'AND');

        // Apply remaining conditions with their operators
        foreach (array_slice($conditions, 1) as $index => $condition) {
            $operator = $logicalOperators[$index] ?? 'AND';
            $this->applyConditionToQuery($query, $condition, $operator);
        }
    }

    /**
     * Apply a condition to the query.
     *
     * @param Builder $query
     * @param string $condition
     * @param string $logicalOperator
     * @return void
     */
    private function applyConditionToQuery(Builder $query, string $condition, string $logicalOperator): void
    {
        $method = $logicalOperator === 'OR' ? 'orWhere' : 'where';
        $query->{$method}(function (Builder $q) use ($condition) {
            if (Str::contains($condition, [' AND ', ' OR '])) {
                $this->parseGroup($condition);
            } else {
                $this->parseCondition($condition, $q);
            }
        });
    }

    /**
     * Parse a single condition.
     *
     * @param string $condition
     * @param Builder|null $query
     * @return void
     */
    private function parseCondition(string $condition, ?Builder $query = null): void
    {
        $query = $query ?: $this->query;
        $operators = ['!=', '>=', '<=', '=', '>', '<', 'HAS_ANY', 'IS_ANY', 'EXISTS', 'LIKE', 'IN'];
        $operator = $this->findOperator($condition, $operators);
        if (!$operator) {
            throw new \InvalidArgumentException("Invalid operator in condition: $condition");
        }
        [$field, $value] = $this->splitCondition($condition, $operator);
        $value = $this->cleanValue($value);
        $this->applyFieldCondition($query, $field, $operator, $value);
    }

    /**
     * Apply field condition based on the field type.
     *
     * @param Builder $query
     * @param string $field
     * @param string $operator
     * @param mixed $value
     * @return void
     */
    private function applyFieldCondition(Builder $query, string $field, string $operator, $value): void
    {
        if (str_starts_with($field, 'attribute:')) {
            $this->applyEavCondition($query, substr($field, 10), $operator, $value);
        } elseif (in_array($field, ['languages', 'locations', 'categories'])) {
            $this->applyRelationshipCondition($query, $field, $operator, $value);
        } else {
            $this->applyStandardCondition($query, $field, $operator, $value);
        }
    }

    /**
     * Apply EAV condition.
     *
     * @param Builder $query
     * @param string $attribute
     * @param string $operator
     * @param mixed $value
     * @return void
     */
    private function applyEavCondition(Builder $query, string $attribute, string $operator, $value): void
    {
        $query->whereHas('attributeValues', function (Builder $q) use ($attribute, $operator, $value) {
            $q->whereHas('attribute', function (Builder $q) use ($attribute) {
                $q->where('name', $attribute);
            });

            switch ($operator) {
                case '=':
                    $q->where('value', $value);
                    break;
                case '!=':
                    $q->where('value', '!=', $value);
                    break;
                case '>':
                    $q->where('value', '>', $value);
                    break;
                case '<':
                    $q->where('value', '<', $value);
                    break;
                case '>=':
                    $q->where('value', '>=', $value);
                    break;
                case '<=':
                    $q->where('value', '<=', $value);
                    break;
                case 'LIKE':
                    $q->where('value', 'LIKE', "%$value%");
                    break;
                case 'IN':
                    $q->whereIn('value', (array)$value);
                    break;
                default:
                    throw new \InvalidArgumentException("Unsupported operator '$operator' for EAV attribute");
            }
        });
    }

    /**
     * Apply relationship condition.
     *
     * @param Builder $query
     * @param string $relation
     * @param string $operator
     * @param mixed $value
     * @return void
     */
    private function applyRelationshipCondition(Builder $query, string $relation, string $operator, $value): void
    {
        $values = is_array($value) ? $value : explode(',', $value);
        $values = array_map('trim', $values);

        $query->whereHas($relation, function (Builder $q) use ($operator, $values) {
            switch ($operator) {
                case '=':
                case 'IS_ANY':
                    $q->whereIn('name', $values);
                    break;
                case 'HAS_ANY':
                    $q->whereIn('name', $values);
                    break;
                case 'EXISTS':
                    break;
                case '!=':
                    $q->whereNotIn('name', $values);
                    break;
                default:
                    throw new \InvalidArgumentException("Unsupported operator '$operator' for relationship");
            }
        });

        if ($operator === 'HAS_ANY') {
            $query->withCount([$relation => function (Builder $q) use ($values) {
                $q->whereIn('name', $values);
            }])->having("{$relation}_count", '>', 0);
        }
    }

    /**
     * Apply standard condition.
     *
     * @param Builder $query
     * @param string $field
     * @param string $operator
     * @param mixed $value
     * @return void
     */
    private function applyStandardCondition(Builder $query, string $field, string $operator, $value): void
    {
        $castValue = $this->castValue($field, $value);

        switch ($operator) {
            case '=':
                $query->where($field, $castValue);
                break;
            case '!=':
                $query->where($field, '!=', $castValue);
                break;
            case '>':
                $query->where($field, '>', $castValue);
                break;
            case '<':
                $query->where($field, '<', $castValue);
                break;
            case '>=':
                $query->where($field, '>=', $castValue);
                break;
            case '<=':
                $query->where($field, '<=', $castValue);
                break;
            case 'LIKE':
                $query->where($field, 'LIKE', "%$value%");
                break;
            case 'IN':
                $query->whereIn($field, (array)$value);
                break;
            default:
                throw new \InvalidArgumentException("Unsupported operator '$operator' for field");
        }
    }

    /**
     * Helper method to find an operator in a condition.
     *
     * @param string $condition
     * @param array $operators
     * @return string|null
     */
    private function findOperator(string $condition, array $operators): ?string
    {
        foreach ($operators as $op) {
            if (str_contains($condition, " $op ")) {
                return $op;
            }
        }
        return null;
    }

    /**
     * Split a condition into field and value.
     *
     * @param string $condition
     * @param string $operator
     * @return array
     */
    private function splitCondition(string $condition, string $operator): array
    {
        $parts = explode(" $operator ", $condition, 2);
        return [trim($parts[0]), trim($parts[1] ?? '')];
    }

    /**
     * Clean the value by removing parentheses if present.
     *
     * @param mixed $value
     * @return mixed
     */
    private function cleanValue($value)
    {
        if (is_string($value) && Str::startsWith($value, '(') && Str::endsWith($value, ')')) {
            $value = substr($value, 1, -1);
        }
        return $value;
    }

    /**
     * Cast the value based on the field type.
     *
     * @param string $field
     * @param mixed $value
     * @return mixed
     */
    private function castValue(string $field, $value)
    {
        if (in_array($field, ['salary_min', 'salary_max'])) {
            return (float)$value;
        }
        if ($field === 'is_remote') {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }
        if (in_array($field, ['job_type', 'status'])) {
            return (string)$value;
        }
        if (Str::contains($field, '_at')) {
            return \Carbon\Carbon::parse($value);
        }
        return $value;
    }

    /**
     * Split conditions into parts.
     *
     * @param string $group
     * @return array
     */
    private function splitConditions(string $group): array
    {
        $parts = [];
        $current = '';
        $depth = 0;

        for ($i = 0; $i < strlen($group); $i++) {
            $char = $group[$i];
            if ($char === '(') $depth++;
            if ($char === ')') $depth--;
            if ($depth === 0 && $i > 0) {
                $nextFour = substr($group, $i, 4);
                $nextThree = substr($group, $i, 3);
                if ($nextFour === ' AND ') {
                    $parts[] = trim($current);
                    $parts[] = 'AND';
                    $current = '';
                    $i += 3;
                    continue;
                } elseif ($nextThree === ' OR ') {
                    $parts[] = trim($current);
                    $parts[] = 'OR';
                    $current = '';
                    $i += 2;
                    continue;
                }
            }
            $current .= $char;
        }

        if (!empty($current)) {
            $parts[] = trim($current);
        }

        return $parts;
    }
}