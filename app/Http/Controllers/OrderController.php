<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json') {
            $orders = Order::paginate(5)->toArray();

            if ($acceptHeader === 'application/json') {
                $response = [
                    "total_count" => $orders["total"],
                    "limit" => $orders["per_page"],
                    "pagination" => [
                        "next_page" => $orders["next_page_url"],
                        "current_page" => $orders["current_page"]
                    ],
                    "data" => $orders["data"],
                ];
                return response()->json($response, 200);
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    public function show($id)
    {
        $acceptHeader = request()->header('Accept');

        if ($acceptHeader === 'application/json') {
            $order = Order::Where(['id' => $id])->with(['ticket', 'user'])->get();

            if (!$order) {
                abort(404);
            }

            return response()->json($order, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }
}
