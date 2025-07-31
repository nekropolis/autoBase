<?php

namespace Modules\KnowledgeBase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Auto\Models\Component;
use Modules\Auto\Models\Modification;

class Instruction extends Model
{
    protected $fillable = [
        'component_id',
        'title',
        'content',
        'media',
        'source_id',
    ];

    protected $casts = [
        'media' => 'array',
    ];

    protected static function booted()
    {
        static::saving(function ($instruction) {
            $instruction->modifications()->sync(request()->input('modification_ids', []));
        });
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function modifications(): BelongsToMany
    {
        return $this->belongsToMany(Modification::class, 'instruction_modification');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'instruction_tag');
    }
}
