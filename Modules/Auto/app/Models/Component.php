<?php

namespace Modules\Auto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\KnowledgeBase\Models\Image;
use Modules\KnowledgeBase\Models\Instruction;


class Component extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['system_id', 'name', 'description'];
    public function system() { return $this->belongsTo(System::class); }
    public function instructions() {
        return $this->hasMany(Instruction::class);
    }
    public function images() {
        return $this->morphMany(Image::class, 'imageable');
    }
}
