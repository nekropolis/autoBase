<?php

namespace Modules\Auto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Auto\Database\Factories\ModificationFactory;

class Modification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['model_id', 'name', 'year_start', 'year_end'];
    public function model() { return $this->belongsTo(ModelAuto::class); }
    public function systems() { return $this->hasMany(System::class); }
}
