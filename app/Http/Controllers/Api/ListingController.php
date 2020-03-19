<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListingRequest;
use App\Http\Resources\ListingResource;
use App\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\Models\Media;
use willvincent\Rateable\Rating;

class ListingController extends Controller
{
    private $paginateCount = 15;

    public function __construct()
    {
        $this->middleware('auth:api')->only(['save', 'user_listings', 'update',  'removeFile']);
    }


    public function index(Request $request)
    {
        $query = Listing::query();
        if($request->query('location')) {
            $query = $query->where('state', $request->query('location'));
        }

        if($request->query('category')) {
            $query = $query->where('category_id', $request->query('category'));
        }

        $results = $query->paginate($this->paginateCount);

        return  response()->json(ListingResource::collection($results));
        // return response()->json(ListingResource::collection(Listing::paginate($this->paginateCount)));
    }

    public function show($id)
    {
        return response()->json(new ListingResource(\App\Listing::findOrFail($id)));
    }

    public function locations()
    {
        $locations = Listing::select('state')->distinct()->get();
       return response()->json( $locations, 200);
    }

    public function search(Request $request)
    {
        // return response()->json($request->has('location'), 200);
        // $query = User::query();

        // if ($this == $that) {
        // $query = $query->where('this', 'that');
        // }

        // if ($this == $another_thing) {
        // $query = $query->where('this', 'another_thing');
        // }

        // if ($this == $yet_another_thing) {
        // $query = $query->orderBy('this');
        // }

        // $results = $query->get();

        $query = Listing::query();
        if($request->query('location')) {
            $query = $query->where('state', $request->query('location'));
        }

        if($request->query('category')) {
            $query = $query->where('category_id', $request->query('category'));
        }

        $results = $query->paginate($this->paginateCount);

        return  response()->json(ListingResource::collection($results));

    }

    public function user_listings() {
        $query = Listing::where('user_id',  auth('api')->user()->id);

        $results = $query->paginate($this->paginateCount);

        return  response()->json(ListingResource::collection($results));
    }

    public function ratings(Listing $listing,Request $request) {
        $validator = Validator::make($request->all(), [
            'review' => 'required',
            'rating' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $rating = new Rating();
        $rating->user_id = auth('api')->user()->id;
        $rating->rating = $request->get('rating');
        $rating->review = $request->get('review');
      //  dd($listing);
        return response()->json($listing->ratings()->save($rating), 200);

    }

    public function store(ListingRequest $request)
    {
        $validatedData = $request->all();

        $validatedData['user_id'] = auth('api')->user()->id;

        $image = null;

        // if ($request->hasFile('images')) {

        //     $validator = Validator::make($request->all(), [
        //         'file' => 'sometimes|image',
        //     ]);

        //     if ($validator->fails()) {
        //         return response()->json($validator->errors(), 422);
        //     }
        //     $file = $request->file('file');
        //     $filename = $file->getClientOriginalName();
        //     $extension = $file->getClientOriginalExtension();
        //     $picture = date('His') . '-' . $filename;

        //     $file->move(public_path('listing'), $picture);
        //     $image = '/listing/' . $picture;

        //     $validatedData['thumbnail'] = $image;

        // } else {
        //     return response()->json(["message" => "No Image found"], 422);
        // }


        $listing = Listing::create($validatedData);

        $files = $request->file('images');

        if ($request->hasFile('images')) {
            foreach ($files as $file) {
                // $file->store('users/' . $this->user->id . '/messages');
                $listing->addMedia($file)->toMediaCollection();
            }
        }

        return response()->json($listing, 201);


    }

    public function update(ListingRequest $request, Listing $listing)
    {
        //    $validator = Validator::make($request->all(), [
        //         'file' => 'sometimes|image',
        //     ]);

        //     if ($validator->fails()) {
        //         return response()->json($validator->errors(), 422);
        //     }

        $validatedData = $request->all();

        $validatedData['user_id'] = auth('api')->user()->id;

        $image = null;

        // https://medium.com/@osaigbovoemmanuel1/make-update-method-on-model-return-model-itself-not-boolean-using-tap-e09cfd321375
        $listing = tap($listing)->update($validatedData);

        $files = $request->file('images');

        if ($request->hasFile('images')) {
            foreach ($files as $file) {
                // $file->store('users/' . $this->user->id . '/messages');
                $listing->addMedia($file)->toMediaCollection();
            }
        }

        return response()->json(["updated"=>$validatedData], 200);
    }

    public function removeFile(Listing $listing, $id)
    {
        // $validatedData = $request->all();

        // $validatedData['user_id'] = auth('api')->user()->id;

        // $image = null;

        // $listing = $listing->save($validatedData);

        // $files = $request->file('images');

        // if ($request->hasFile('images')) {
        //     foreach ($files as $file) {
        //         // $file->store('users/' . $this->user->id . '/messages');
        //         $listing->addMedia($file)->toMediaCollection();
        //     }
        // }
        Media::find($id)->delete();

        return response()->json($listing->getMediaItems(), 200);
    }
}
