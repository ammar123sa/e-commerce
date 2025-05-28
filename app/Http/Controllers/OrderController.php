<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
     public function store(StoreOrderRequest $request)
    {
        $pricePerUnit = 10;
        $total = $request->quantity * $pricePerUnit;

        $order = Order::create([
            'quantity' => $request->quantity,
            'total_amount' => $total,
            'is_paid' => true,
        ]);

        return response()->json([
            'message' => 'تم الدفع بنجاح ✅',
            'order' => new OrderResource($order),
        ]);
    }
}
