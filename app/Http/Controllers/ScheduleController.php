<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json') {
            $Schedules = Schedule::paginate(5)->toArray();

            if ($acceptHeader === 'application/json') {
                $response = [
                    "total_count" => $Schedules["total"],
                    "limit" => $Schedules["per_page"],
                    "pagination" => [
                        "next_page" => $Schedules["next_page_url"],
                        "current_page" => $Schedules["current_page"]
                    ],
                    "data" => $Schedules["data"],
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
            $Schedule = Schedule::findOrFail($id);

            return response()->json($Schedule, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    public function store()
    {
        $acceptHeader = request()->header('Accept');

        if ($acceptHeader === 'application/json') {
            // $contentTypeHeader = request()->header('Content-Type');

            $attr = request()->all();

            $Schedule = Schedule::create($attr);

            return response()->json($Schedule, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    public function update($id, Request $request)
    {
        $acceptHeader = request()->header('Accept');

        if ($acceptHeader === 'application/json') {
            // $contentTypeHeader = request()->header('Content-Type');

            $input = $request->all();
            $Schedule = Schedule::findOrFail($id);

            $Schedule->fill($input);
            $Schedule->save();

            return response()->json($Schedule, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    public function destroy($id)
    {
        $acceptHeader = request()->header('Accept');

        if ($acceptHeader === 'application/json') {
            $Schedule = Schedule::findOrFail($id);

            $Schedule->delete();

            $message = ['message' => 'delete successfully', 'Schedule_id' => $id];
            return response()->json($message, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }
}
