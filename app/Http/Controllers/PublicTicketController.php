<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicTicketController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json') {
            $tickets = Ticket::Where(['user_id' => Auth::user()->id])->OrderBy("id", "DESC")->paginate(5)->toArray();

            if ($acceptHeader === 'application/json') {
                $response = [
                    "total_count" => $tickets["total"],
                    "limit" => $tickets["per_page"],
                    "pagination" => [
                        "next_page" => $tickets["next_page_url"],
                        "current_page" => $tickets["current_page"]
                    ],
                    "data" => $tickets["data"],
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
            $ticket = Ticket::Where(['user_id' => Auth::user()->id])->Where(['id' => $id])->OrderBy("id", "DESC")->with(['station', 'schedule'])->get();

            if (!$ticket) {
                abort(404);
            }
            
            return response()->json($ticket, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }
}
