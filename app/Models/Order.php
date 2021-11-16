<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    protected $fillable = ['customer','phone','user_id','type','status',];
    // получаем пользователя
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    //получаем продукты
    public function products()
    {
        return $this->belongsToMany(Product::class,'order_items','order_id','product_id')->withPivot('count', 'discount','cost');
    }
    //получаем записи о корзине заказа
    public function orderItems()
    {
        return $this->hasMany(Order_item::class,'order_id','id');
    }
    // вычищаем все записи
    public static function boot() {
        parent::boot();

        static::deleting(function($order) {
            $order->itemsProduct()->delete();
        });
    }
}
