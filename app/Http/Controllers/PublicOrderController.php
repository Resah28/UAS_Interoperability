<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PublicOrderController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json') {
            $orders = Order::Where(['user_id' => Auth::user()->id])->OrderBy("id", "DESC")->paginate(5)->toArray();

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
            $order = Order::Where(['user_id' => Auth::user()->id])->Where(['id' => $id])->OrderBy("id", "DESC")->with(['ticket', 'user'])->get();

            if (!$order) {
                abort(404);
            }

            return response()->json($order, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    public function store()
    {
        $tickets = request()->input('ticket_id');

        $acceptHeader = request()->header('Accept');

        if ($acceptHeader === 'application/json') {
            // $contentTypeHeader = request()->header('Content-Type');

            $ticket = Ticket::where(["id" => $tickets])->firstOrFail();

            $attr = new Order;
            $attr->user_id = auth()->user()->id;
            $attr->ticket_id = $ticket['id'];
            $attr->total_harga = $ticket['harga'];

            $attr->save();

            return response()->json($attr, 200);
        } else {
            return response('Media tidak support!', 406);
        }
    }

    public function destroy($id)
    {
        $acceptHeader = request()->header('Accept');

        if ($acceptHeader === 'application/json') {
            $order = Order::where(['id' => $id])->firstOrFail();

            if (!$order) {
                abort(404);
            }

            $order->delete();

            $message = ['message' => 'delete successfully', 'order_id' => $id];
            return response()->json($message, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }
}
