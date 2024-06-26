<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'name',
        'content',
        'text_1_icon',
        'text_1_content',
        'text_1',
        'text_2_icon',
        'text_2_content',
        'text_2',
        'text_3_icon',
        'text_3_content',
        'text_3',
    ];

    public function images(){
        return $this->hasOne(İmageMedia::class,'table_id','id')->where('model_name','About');
    }
}
