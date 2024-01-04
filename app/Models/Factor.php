<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factor extends Model
{
    use HasFactory;
    use softDeletes;
    protected $date = ['deleted_at'];
    protected $fillable=[
        'order_id',
        'title',
        'total_price',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
}
