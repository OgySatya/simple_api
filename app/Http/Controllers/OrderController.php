<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = Order::all()->select(
            'id',
            'costomer_name',
            'table_number',
            'order_time',
            'status',
            'total_price',
            'waiter_id',
        );
        return $order;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'costomer_name' => 'required|max:255',
            'table_number' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();
            $data = $request->only(['costomer_name', 'table_number']);
            $data['order_time'] = date('d-m-Y H:i');
            $data['status'] = 'On Prosess';
            $data['total_price'] = 0;
            $data['waiter_id'] = auth()->user()->id;
            $data['items'] = $request->items;

            $order = Order::create($data);

            collect($data['items'])->map(function ($item) use ($order) {
                $pesanan = Item::where('id', $item)->first();
                OrderDetail::create([
                    'order_id' => $order->id,
                    'item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => ($pesanan->price * $item['quantity'])

                ]);
            });

            $order->total_price = $order->totalPrice();
            $order->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return response($th);
        }

        return response($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        return $order->loadMissing('user:id,name', 'orderDetail:order_id,item_id,quantity', 'orderDetail.item:id,name,price');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function orderReady(Request $request, string $id)
    {
        $order = Order::findOrFail($id);
        $order->chef_id = $request->id;
        $order->status = 'Ready';
        $order->save();
        return response($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function payment(string $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'Lunas';
        $order->cashier_id = auth()->user()->id;
        $order->save();
        return response($order);
    }
    public function serve(string $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'Served';
        $order->save();
        return response($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);

        if ($order) {
            $order->delete();
            return 'order deleted successfully.';
        }

        return 'error order not found.';
    }
}
