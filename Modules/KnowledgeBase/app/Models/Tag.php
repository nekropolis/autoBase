<?php

namespace Modules\KnowledgeBase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name'];
    public function instructions() {
        return $this->belongsToMany(Instruction::class);
    }
    public function problems() {
        return $this->belongsToMany(Problem::class);
    }
}
