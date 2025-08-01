<?php

namespace Modules\KnowledgeBase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Posts\Models\Post;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public function instructions() {
        return $this->belongsToMany(Instruction::class);
    }
    public function problems() {
        return $this->belongsToMany(Problem::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
