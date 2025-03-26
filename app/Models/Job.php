<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'company_name',
        'salary_min',
        'salary_max',
        'is_remote',
        'job_type',
        'status',
        'published_at'
    ];

    protected $casts = [
        'is_remote' => 'boolean',
        'published_at' => 'datetime',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    public function languages() {
        return $this->belongsToMany(Language::class, 'job_language');
    }

    public function locations() {
        return $this->belongsToMany(Location::class, 'job_location');
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'job_category');
    }

    public function attributeValues() {
        return $this->hasMany(JobAttributeValue::class);
    }
}
