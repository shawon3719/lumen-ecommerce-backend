<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin_check:index');
    }

    public function index()
    {
        // all users count
        $totalMembers = User::where("is_super_admin", 0)->count();

        // total items sold
        $totalItemsSold = 0;
        $orders = Order::with("orderDetails")->where('status', 'success')->get();

        foreach ($orders as $order) {
            $totalItemsSold += $order->countOrderItems();
        }

        // total items this week
        $totalItemsSoldThisWeek = 0;
        $orders = Order::with("orderDetails")->where('status', 'success')
            ->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        foreach ($orders as $order) {
            $totalItemsSoldThisWeek += $order->countOrderItems();
        }

        // total earnings
        $totalEarnings = 0;
        $orders = Order::where('status', 'success')->get();
        foreach ($orders as $order) {
            $totalEarnings += $order->total_price;
        }

        return response()->json([
           "totalMembers" => $totalMembers,
           "totalItemsSold" => $totalItemsSold,
           "totalItemsThisWeek" => $totalItemsSoldThisWeek,
           "totalEarnings" => number_format($totalEarnings, 2)
        ]);
    }
}