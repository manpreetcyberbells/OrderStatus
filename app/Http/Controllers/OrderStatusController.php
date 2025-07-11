<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Shop;
use Carbon\Carbon;

class OrderStatusController extends Controller
{
    public function statusForm()
    {
        return view('orders.statusForm');
    }

    public function checkOrderStatus(Request $request)
    {
        $orderNumber = $request->query('order_number');
        if (!$orderNumber) {
            return response()->json(['error' => 'Missing order number'], 400);
        }

        $apiKey = env('SHOPIFY_ACCESS_TOKEN');
        $apiPassword = env('SHOPIFY_SHARED_SECRET');
        $shopDomain = env('SHOPIFY_SHOP');

        $url = "https://{$apiKey}:{$apiPassword}@{$shopDomain}/admin/api/2024-04/orders.json";
        // die($url);
        $response = Http::get($url, [
            'name' => '#' . $orderNumber,
        ]);

        $data = $response->json();

        // echo"<pre>"; print_r($response->json());  die;

        if ($response->failed() || empty($response['orders'])) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order = $data['orders'][0];

        $createdAt = Carbon::parse($order['created_at']);
        $now = Carbon::now();
        $hoursDiff = $createdAt->diffInHours($now);
        if ($hoursDiff <= 24) {
            $statusMessage = "Your order is being processed";
        } elseif ($hoursDiff <= 72) {
            $statusMessage = "Your items are in production";
        } elseif ($hoursDiff <= 120) {
            $statusMessage = "Packaging and preparing for shipment";
        } else {
            $statusMessage = "Shipped or awaiting final tracking";
        }

        return response()->json([
            'order_number' => $order['name'],
            'created_at' => $order['created_at'],
            'status_message' => $statusMessage,
        ]);
    }
}
