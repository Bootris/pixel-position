<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Job extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Add provided tag by name.
     */
    public function addTag(string $name): void
    {
        $tag = Tag::firstOrCreate(['name' => strtolower($name)]);

        $this->tags()->attach($tag);
    }

    /**
     * Get the tags that belong to job.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'job_tag');
    }

    /**
     * Get employeer that owns the job.
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }
}
