<?php

namespace Modules\KnowledgeBase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Source extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title', 'type', 'url', 'note'];
    public function solutions() {
        return $this->hasMany(Solution::class);
    }
}
