<?php

namespace Modules\KnowledgeBase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Solution extends Model
{
    use HasFactory;

    protected $fillable = [
        'problem_id',
        'source_id',
        'instruction_id',
        'description',
        'is_verified',
    ];

    public function problem(): belongsTo
    {
        return $this->belongsTo(Problem::class);
    }

    public function source(): belongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function instruction(): belongsTo
    {
        return $this->belongsTo(Instruction::class);
    }
}
