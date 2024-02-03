<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Train;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json') {
            $trains = Train::paginate(5)->toArray();

            if ($acceptHeader === 'application/json') {
                $response = [
                    "total_count" => $trains["total"],
                    "limit" => $trains["per_page"],
                    "pagination" => [
                        "next_page" => $trains["next_page_url"],
                        "current_page" => $trains["current_page"]
                    ],
                    "data" => $trains["data"],
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
            $train = Train::where(['slug' => $slug])->with('station')->get();

            if (!$train) {
                abort(404);
            }

            return response()->json($train, 200);
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
                $attr['slug'] = Str::slug(request('nama'));

                $validationRules = [
                    "nama" => 'required|min:5',
                    "slug" => 'required|min:5',
                    "kelas" => 'required|min:5',
                    'station_id' => 'required|exists:stations,id'
                ];

                $validator = Validator::make($attr, $validationRules);

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 400);
                }
                $train = Train::create($attr);

                return response()->json($train, 200);
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
                    "slug" => 'required|min:5',
                    "kelas" => 'required|min:5',
                    'station_id' => 'required|exists:stations,id'
                ];

                $validator = Validator::make($input, $validationRules);

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 400);
                }

                $train = Train::where(['slug' => $slug])->firstOrFail();

                $train->fill($input);
                $train->save();

                return response()->json($train, 200);
        } else {
            return response('Media tidak support!', 406);
        }
    }

    public function destroy($slug)
    {
        $acceptHeader = request()->header('Accept');

        if ($acceptHeader === 'application/json') {
            $train = Train::where(['slug' => $slug])->firstOrFail();

            if (!$train) {
                abort(404);
            }

            $train->delete();

            $message = ['message' => 'delete successfully', 'train_slug' => $slug];
            return response()->json($message, 200);
        } else {
            return response('Media tidak support!', 406);
        }
    }
}
