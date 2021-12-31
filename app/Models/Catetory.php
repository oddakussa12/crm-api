<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catetory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    public function blogs(){
        return $this->hasMany('App\Models\Blog');
    }
    public function subcategories(){
        return $this->hasMany('App\Models\Subcategory');
    }
}
