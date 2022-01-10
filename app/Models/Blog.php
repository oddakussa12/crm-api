<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'author',
        'body',
        'date'
        // 'file',
        // 'thumbnail',
        // 'description',
        // 'category_id',
        // 'subcategory_id',
    ];
    // public function category(){
    //     return $this->belongsTo('App\Models\Catetory');
    // }
    // public function subcategory(){
    //     return $this->belongsTo('App\Models\Subcategory');
    // }
}
