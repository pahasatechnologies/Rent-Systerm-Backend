<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListingRequest;
use App\Http\Resources\ListingResource;
use App\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ListingController extends Controller
{
    private $paginateCount = 15;

    public function __construct()
    {
        $this->middleware('auth:api')->only(['save']);
    }


    public function index()
    {
        return response()->json(ListingResource::collection(Listing::paginate($this->paginateCount)));
    }

    public function show($id)
    {
        return response()->json(new ListingResource(\App\Listing::findOrFail($id)));
    }

    public function store(ListingRequest $request)
    {
        $validatedData = $request->all();

        $validatedData['user_id'] = auth('api')->user()->id;

        $image = null;

        if ($request->hasFile('file')) {
            $validator = Validator::make($request->all(), [
                'file' => 'sometimes|image',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture = date('His') . '-' . $filename;

            $file->move(public_path('listing'), $picture);
            $image = '/listing/' . $picture;

            $validatedData['thumbnail'] = $image;

        } else {
            return response()->json(["message" => "No Image found"], 422);
        }


        $listing = Listing::create($validatedData);

        return response()->json($listing, 200);


    }
}
