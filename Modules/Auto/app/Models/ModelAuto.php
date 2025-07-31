<?php

namespace Modules\Auto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Auto\Database\Factories\ModelAutoFactory;

class ModelAuto extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'models';
    protected $fillable = ['brand_id', 'name', 'slug', 'year_start', 'year_end', 'description'];
    public function brand() { return $this->belongsTo(Brand::class); }
    public function modifications() { return $this->hasMany(Modification::class); }
}
