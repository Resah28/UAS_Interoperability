<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class StationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json') {
            $stations = Station::paginate(5)->toArray();

            if ($acceptHeader === 'application/json') {
                $response = [
                    "total_count" => $stations["total"],
                    "limit" => $stations["per_page"],
                    "pagination" => [
                        "next_page" => $stations["next_page_url"],
                        "current_page" => $stations["current_page"]
                    ],
                    "data" => $stations["data"],
                ];
                return response()->json($response, 200);
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    public function show($slug)
    {
        $acceptHeader = request()->header('Accept');

        if ($acceptHeader === 'application/json') {
            $station = Station::where(['slug' => $slug])->with('trains')->get();

            if (!$station) {
                abort(404);
            }

            return response()->json($station, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    public function store()
    {
        $acceptHeader = request()->header('Accept');

        if ($acceptHeader === 'application/json') {
            $contentTypeHeader = request()->header('Content-Type');

            if ($contentTypeHeader === 'multipart/form-data; boundary=<calculated when request is sent>') {
                $attr = request()->all();
                $attr['slug'] = Str::slug(request('nama'));

                $validationRules = [
                    "nama" => 'required|min:5',
                    "kota" => 'required|min:5',
                ];

                $validator = Validator::make($attr, $validationRules);

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 400);
                }
                $station = Station::create($attr);

                return response()->json($station, 200);
            } else {
                return response('Unsupported Media Type', 415);
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    public function update($slug)
    {
        $acceptHeader = request()->header('Accept');

        if ($acceptHeader === 'application/json') {
            // $contentTypeHeader = request()->header('Content-Type');
                $input = request()->all();
                $input['slug'] = Str::slug(request('nama'));

                $validationRules = [
                    "nama" => 'required|min:5',
                    "kota" => 'required|min:5',
                ];

                $validator = Validator::make($input, $validationRules);

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 400);
                }

                $station = Station::where(['slug' => $slug])->firstOrFail();

                if (!$station) {
                    abort(404);
                }

                $station->fill($input);
                $station->save();

                return response()->json($station, 200);

        } else {
            return response('Not Acceptable!', 406);
        }
    }

    public function destroy($slug)
    {
        $acceptHeader = request()->header('Accept');

        if ($acceptHeader === 'application/json') {
            $station = Station::where(['slug' => $slug])->firstOrFail();

            if (!$station) {
                abort(404);
            }

            $station->delete();

            $message = ['message' => 'delete successfully', 'station_slug' => $slug];
            return response()->json($message, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }
}
