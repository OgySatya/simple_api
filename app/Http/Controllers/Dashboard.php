<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Role;
use Illuminate\Http\Request;

use function Pest\Laravel\get;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['totalamount'] = Order::where('status', 'Lunas')->sum('total_price');
        $data['totalorder'] = Order::count();
        $data['users'] = Role::all()->loadMissing('users:role_id,name');
        $data['totalitem'] = Item::count();
        $data['allorder'] = Order::all()->loadMissing(['waiter:id,name', 'chef:id,name', 'cashier:id,name']);
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function report(Request $request)
    {
        $startDate = $request->start;
        $endDate = $request->end;

        $filterData = Order::whereBetween('created_at', [$startDate, $endDate])->get();
        $data['totalamount'] = $filterData->where('status', 'Lunas')->sum('total_price');
        $data['totalorder'] = $filterData->count();
        $data['users'] = Role::all()->loadMissing('users:role_id,name');
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
