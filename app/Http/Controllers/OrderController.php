<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Order_item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    public function list()
    {
        return Order::with('user')->get(); // отдаем список всех заказов
    }

    public function get($id)
    {

        if (Order::find($id) == null) return // сущ. ли заказ
            [
                'type' => 'error',
                'message' => 'Не существует такого заказа'
            ];

        return Order::where('id',$id)->with('products','user')->first(); // отдаем заказ
    }
    public function delete($id)
    {
        Order::find($id)->delete();
    }
    public function create(Request $request)
    {
        $data = $request->all(); // получаем тело запроса
        // Старт транкзации, на случай если в одном из продуктов потребуется купить больше на
        // складе, запросы откатятся и будет отправлено соответствующее уведомление
        DB::beginTransaction();

        $order = Order::create($request->all());
        // передаем заказ и продукты
        $this->createOrderItems($order,$data);

        return [
            'type' => 'success',
            'message' => 'Заказ успешно создан, товары добавлены.'
        ];
    }

    public function update(Request $request)
    {
        $data = $request->all();
        // точно так же не обновит запись если продуктов не хватит
        DB::beginTransaction();

        $order = Order::find($data['id']);

        $order->customer = $data['customer'];
        $order->phone = $data['phone'];
        $order->user_id = $data['user_id'];
        $order->type = $data['type'];
        $order->status = $data['status'];

        $order->save();

        // удаляем старые записи посредством  цикла,
        // для вызова события удаления в модели и возврата нужного количества на склад
        foreach ($order->orderItems as $item) {
            $item->delete();
        }
        // передаем заказ и продукты
        $this->createOrderItems($order,$data);

        return [
            'type' => 'success',
            'message' => 'Заказ успешно обновлен.'
        ];

    }
    public function createOrderItems($order,$data) {

        foreach ($data['products'] as $item) {
            // добавляем нужные данные
            $item['order_id'] = $order->id;
            $item['product_id'] = $item['id'];
            $product = Product::find($item['product_id']);
            // если кол-во превышает кол-во на складе
            if ($product->stock - $item['count'] <= 0) {
                return [
                    'type' => 'error',
                    'message' => 'Товар который вы пытаетесь купить ('.$item['name'].') не хватает или закончился на складе. Повторите попытку.<br>
                        Количество на складе: '.$product->stock
                ];
                DB::rollBack();
                break;
            } else {
                $product->stock -= $item['count'];
                $product->save(); // сохраняем

                Order_item::create($item);
            }
        }

        DB::commit(); // коммитим изменния в базу
    }

    public function report(Request $request)
    {
        $data = $request->all();
        $orders = Order::whereDate('created_at',$data['date'])->get(); // ищем заказы за нужный день

        $sum = 0;
        foreach ($orders as $order) {
            $sum += $order->orderItems->sum('cost'); // плюсуем сумму
        }

        return [
            'count' => count($orders),
            'sum' => $sum
        ];
    }
}
