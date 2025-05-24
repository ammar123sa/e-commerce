<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function store(OrderRequest $request)
    {
        $user = Auth::user();

        $order = Order::create([
            'user_id' => $user->id,
            'total'   => $request->total,
            'status'  => 'pending',
        ]);

        $paymentSuccess = true;

        $order->update([
            'status' => $paymentSuccess ? 'paid' : 'failed',
        ]);

        return new OrderResource($order);
    }
}
