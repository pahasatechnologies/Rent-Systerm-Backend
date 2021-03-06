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
        $this->middleware('auth:api')->only([
            'save',
            'user_listings',
            'update',
            'destroy',
            'removeFile',
            'is_bookmarked',
            'get_bookmarks',
            'add_bookmark',
            'remove_bookmark',
        ]);
    }

    public function index(Request $request)
    {
        $query = Listing::query();
        $paginationCount = $this->paginateCount;

        if ($request->query('location')) {
            $query = $query->where('state', $request->query('location'));
        }

        if ($request->query('category')) {
            $query = $query->where('category_id', $request->query('category'));
        }

        if ($request->query('bhk')) {
            $query = $query->where('bhk', $request->query('bhk'));
        }

        if ($request->query('furnishing')) {
            $query = $query->where('furnishing', $request->query('furnishing'));
        }

        if ($request->query('property_type')) {
            $query = $query->where('property_type', $request->query('property_type'));
        }

        if ($request->query('price')) {
            $query = $query->whereBetween('price', (explode(',',$request->query('price'))));
        }

        if ($request->query('count')) {
            $paginationCount =  $request->query('count');
        }

        $query->orderBy('updated_at', 'DESC')
            ->orderBy('created_at', 'DESC');

        $results = $query->paginate($paginationCount);

        // return response()->json(explode(',',$request->query('price')));
        return response()->json(ListingResource::collection($results));
        // return response()->json(ListingResource::collection(Listing::paginate($this->paginateCount)));
    }

    public function latest()
    {
        $query = Listing::latest()->take(5)->get();

        return response()->json(ListingResource::collection($query));
    }

    public function top()
    {
        $query = Listing::where('is_featured', true)->take(8)->get();

        return response()->json(ListingResource::collection($query));
    }


    public function show($id)
    {
        return response()->json(new ListingResource(\App\Listing::findOrFail($id)));
    }

    public function locations()
    {
        $locations = Listing::select('state')->distinct()->get();
        return response()->json($locations, 200);
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
        if ($request->query('location')) {
            $query = $query->where('state', $request->query('location'));
        }

        if ($request->query('category')) {
            $query = $query->where('category_id', $request->query('category'));
        }

        if ($request->query('bhk')) {
            $query = $query->where('bhk', $request->query('bhk'));
        }

        if ($request->query('furnishing')) {
            $query = $query->where('furnishing', $request->query('furnishing'));
        }

        if ($request->query('property_type')) {
            $query = $query->where('property_type', $request->query('property_type'));
        }

        $results = $query->paginate($this->paginateCount);

        return response()->json(ListingResource::collection($results));
    }

    public function user_listings()
    {
        $query = Listing::where('user_id', auth('api')->user()->id);

        $results = $query->paginate($this->paginateCount);

        return response()->json(ListingResource::collection($results));
    }

    public function ratings(Listing $listing, Request $request)
    {
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

        return response()->json(["updated" => $validatedData], 200);
    }

    public function destroy(Listing $listing)
    {
        $listing->delete();
        $listing->clearMediaCollection();
        return response()->json($listing, 200);
    }

    public function setFeatured(Listing $listing, Request $request)
    {
        $status = $request->get('status');
        $listing->is_featured = $status;
        $listing->save();
        return response()->json($listing, 200);
    }

    public function setActiveStatus(Listing $listing, Request $request)
    {
        $status = $request->get('status');
        $listing->is_active = $status;
        $listing->save();
        return response()->json($listing, 200);
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

    public function is_bookmarked(Listing $listing)
    {
        return response()->json(["is_bookmarked" => $listing->is_bookmarked(auth('api')->user())], 200);
    }

    public function get_bookmarks()
    {
        $bookmarks = auth('api')->user()->bookmarks;
        return response()->json(ListingResource::collection($bookmarks), 200);
    }

    public function add_bookmark(Listing $listing)
    {
        $user = auth('api')->user();
        $user->bookmarks()->attach($listing->id);

        return response()->json(["is_bookmarked" => $listing->is_bookmarked(auth('api')->user())], 200);
    }

    public function remove_bookmark(Listing $listing)
    {
        $user = auth('api')->user();
        $user->bookmarks()->detach($listing->id);

        return response()->json(["is_bookmarked" => $listing->is_bookmarked(auth('api')->user())], 200);
    }
}
