<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListingResource;
use App\Listing;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    private $paginateCount = 15;

    public function __construct()
    {
        $this->middleware('auth:api')->only([
            'listings',
        ]);

        $this->middleware('admin')->only([
            'listings',
        ]);
    }

    public function listings(Request $request)
    {
        $query = Listing::query();
        $paginationCount = $this->paginateCount;

        if ($request->query('location')) {
            $query = $query->where('state', $request->query('location'));
        }

        if ($request->query('category')) {
            $query = $query->where('category_id', $request->query('category'));
        }

        if ($request->query('count')) {
            $paginationCount =  $request->query('count');
        }

        $results = $query->paginate($paginationCount);

        return response()->json(ListingResource::collection($results));
        // return response()->json(ListingResource::collection(Listing::paginate($this->paginateCount)));
    }

    public function dashboard(Request $request) {
            $userCount = User::count();
            $listingCount = Listing::count();

            // $latestListings = Listing::latest()->take(5)->get();

            $query = Listing::latest()->take(4)->get();
            $latestListings = ListingResource::collection($query);

            return response()->json(compact(['userCount', 'listingCount', 'latestListings']));
    }

    public function users(Request $request)
    {
        $query = User::query();
        $paginationCount = $this->paginateCount;

        if ($request->query('count')) {
            $paginationCount =  $request->query('count');
        }


        return response()->json($query->paginate($paginationCount));
        // return response()->json(ListingResource::collection(Listing::paginate($this->paginateCount)));
    }

    public function user_listings(Request $request, User $user)
    {
        $query = Listing::where('user_id', $user->id);

        $results = $query->paginate($this->paginateCount);

        return response()->json(ListingResource::collection($results));
    }

}
