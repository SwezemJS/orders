<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
class Order_item extends Model
{
    public $timestamps = false;
    protected $fillable = ['order_id','product_id','count','discount','cost',];

    public static function boot() {
        parent::boot();
        // сработает при удалении записи и зачислит все продукты обратно на склад
        static::deleting(function($itemOrder) {
            $product = Product::find($itemOrder->product_id);
            $product->stock += $itemOrder->count;
            $product->save();
        });
    }
}
