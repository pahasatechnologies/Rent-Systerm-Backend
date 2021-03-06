<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ListingResource extends JsonResource
{
    // https://stackoverflow.com/questions/55685447/how-to-get-pagination-links-in-resource-collection-laravel-5-7-19
    public static function collection($data)
    {
        /* is_a() makes sure that you don't just match AbstractPaginator
         * instances but also match anything that extends that class.
         */
        if (is_a($data, \Illuminate\Pagination\AbstractPaginator::class)) {
            $data->setCollection(
                $data->getCollection()->map(function ($listing) {
                    return new static($listing);
                })
            );

            return $data;
        }

        return parent::collection($data);
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'addressLineOne' => $this->addressLineOne,
            'addressLineTwo' => $this->addressLineTwo,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'pincode' => $this->pincode,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'thumbnail' => $this->thumbnail,
            'images' => $this->getUrl(),
            'media' => $this->getMediaItems(),
            'rating' => (float) $this->averageRating(),
            'reviews' => $this->ratings()->with('user')->get(),
            'price' =>  "₹ ".$this->price,
            'user_id' => $this->user_id,
            'user' => $this->user,
            'bhk' => $this->bhk,
            'furnishing' => $this->furnishing,
            'property_type' => $this->property_type,
            'category' => $this->category->name,
            'category_id' => $this->category_id,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
