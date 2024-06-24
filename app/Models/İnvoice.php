<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class İnvoice extends Model
{
    use HasFactory;
    protected $fillable = ['order_no',
                            'name',
                            'email',
                            'phone',
                            'country',
                            'company_name',
                            'address',
                            'city',
                            'district',
                            'posta_zip',
                            'note',
                            'status'];

        public function orders()
        {
           return $this->hasMany(Order::class,'order_no','order_no');
        }
}

