<?php

namespace Modules\KnowledgeBase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Symptom extends Model
{
    use HasFactory;

    protected $fillable = [
        'problem_id',
        'description',
    ];

    public function problem(): belongsTo
    {
        return $this->belongsTo(Problem::class);
    }
}
