<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['job_id', 'attribute_id', 'value'];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    // public function getValueAttribute($value) {
    //     $type = $this->attribute->type;
    //     return match ($type) {
    //         'number' => (float) $value,
    //         'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
    //         'date' => \Carbon\Carbon::parse($value),
    //         default => $value,
    //     };
    // }
}
