<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use function Pest\Laravel\get;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['totalamount'] = Order::where('status', 'Lunas')->sum('total_price');
        $data['totalorder'] = Order::count();
        $data['users'] = User::count();
        $data['totalitem'] = Item::count();
        $data['allorder'] = Order::all()->loadMissing(['waiter:id,name', 'chef:id,name', 'cashier:id,name']);
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function report(Request $request)
    {
        $startDate = $request->get('start', null);
        $endDate = $request->get('end', null);

        $filterData = Order::query();
        if ($startDate) {
            $filterData = $filterData->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $filterData = $filterData->whereDate('created_at', '<=', $endDate);
        }
        $filterData = $filterData->get();

        $data['totalamount'] = $filterData->where('status', 'Lunas')->sum('total_price');
        $data['totalorder'] = $filterData->count();
        $data['users'] = User::count();
        $data['totalitem'] = Item::count();
        $data['allorder'] = $filterData->loadMissing(['waiter:id,name', 'chef:id,name', 'cashier:id,name']);
        return response($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
