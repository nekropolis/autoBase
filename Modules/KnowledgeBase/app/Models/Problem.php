<?php

namespace Modules\KnowledgeBase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Auto\Models\Modification;

class Problem extends Model
{
    use HasFactory;

    protected $fillable = ['modification_id', 'title', 'description'];
    public function modifications(): BelongsToMany
    {
        return $this->belongsToMany(Modification::class, 'problem_modification');
    }
    public function symptoms(): hasMany
    {
        return $this->hasMany(Symptom::class);
    }

    public function solutions(): hasMany
    {
        return $this->hasMany(Solution::class);
    }
    public function sources()
    {
        return $this->hasManyThrough(
            Source::class,
            Solution::class,
            'problem_id',
            'id',
            'id',
            'source_id',
        );
    }
    public function tags(): belongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
