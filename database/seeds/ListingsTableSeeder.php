<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $propertyJsonData = '[
            {
            "id": 1,
            "title": "Cozzy Coffee Shop",
            "address": "4700 Hart Country Lane Blue Ridge",
            "price": "false",
            "thumbnail": "assets/img/tmp/listing-1.jpg",
            "verified": false,
            "latitude": 47.590115,
            "longitude": -122.246911
            }
            ,
            {
            "id": 2,
            "title": "Piano Lessons For Beginners",
            "address": "3071 Ash Avenue Saint Louis",
            "price": "44.90",
            "thumbnail": "assets/img/tmp/listing-2.jpg",
            "verified": true,
            "latitude": 47.610632,
            "longitude": -122.22496
            }
            ,
            {
            "id": 3,
            "title": "Delicious Ocean Restaurant",
            "address": "3827 Sycamore Lake Road Fremont",
            "price": "99.90",
            "thumbnail": "assets/img/tmp/listing-3.jpg",
            "verified": false,
            "latitude": 47.586344,
            "longitude": -122.247593
            }
            ,
            {
            "id": 4,
            "title": "Healthy Breakfast",
            "address": "1148 Elk Rd Little Tucson",
            "price": "129.90",
            "thumbnail": "assets/img/tmp/listing-4.jpg",
            "verified": true,
            "latitude": 47.607565,
            "longitude": -122.286378
            }
            ,
            {
            "id": 5,
            "title": "London Trip",
            "address": "1464 Briercliff Road Bronx",
            "price": "54.00",
            "thumbnail": "assets/img/tmp/listing-5.jpg",
            "verified": false,
            "latitude": 47.580839,
            "longitude": -122.245504
            }
            ,
            {
            "id": 6,
            "title": "Bio Vegatables",
            "address": "4419 Railroad Street Marquette",
            "price": "77.40",
            "thumbnail": "assets/img/tmp/listing-6.jpg",
            "verified": false,
            "latitude": 47.560816,
            "longitude": -122.251902
            }
            ,
            {
            "id": 7,
            "title": "Food Lessons",
            "address": "1890 Cedarstone Drive New Knoxville",
            "price": "false",
            "thumbnail": "assets/img/tmp/listing-7.jpg",
            "verified": false,
            "latitude": 47.580273,
            "longitude": -122.285868
            }
            ,
            {
            "id": 8,
            "title": "Paris Museum",
            "address": "2858 Neuport Lane Norcross",
            "price": "87.43",
            "thumbnail": "assets/img/tmp/listing-8.jpg",
            "verified": true,
            "latitude": 47.581728,
            "longitude": -122.301586
            }
            ,
            {
            "id": 9,
            "title": "Photo Services",
            "address": "3074 Asylum Avenue Danbury",
            "price": "64.60",
            "thumbnail": "assets/img/tmp/listing-9.jpg",
            "verified": true,
            "latitude": 47.594203,
            "longitude": -122.316993
            }
            ,
            {
            "id": 10,
            "title": "Nightlife Party Club",
            "address": "1542 Rocket Drive Minneapolis",
            "price": "7.90",
            "thumbnail": "assets/img/tmp/listing-10.jpg",
            "verified": false,
            "latitude": 47.601496,
            "longitude": -122.330039
            }
            ,
            {
            "id": 11,
            "title": "Kebab Restaurant",
            "address": "463 Davis Lane Denver",
            "price": "342.00",
            "thumbnail": "assets/img/tmp/listing-11.jpg",
            "verified": false,
            "latitude": 47.606733,
            "longitude": -122.312701
            }
            ,
            {
            "id": 12,
            "title": "T-Shirt Specialized Shop",
            "address": "2460 Ashwood Drive Farragut",
            "price": "533.00",
            "thumbnail": "assets/img/tmp/listing-12.jpg",
            "verified": false,
            "latitude": 47.634781,
            "longitude": -122.227362
            }
            ,
            {
            "id": 13,
            "title": "SUV Cars Reseller",
            "address": "4692 Arbutus Drive Miami Springs",
            "price": "false",
            "thumbnail": "assets/img/tmp/listing-13.jpg",
            "verified": false,
            "latitude": 47.638774,
            "longitude": -122.284838
            }
            ,
            {
            "id": 14,
            "title": "Skateshop",
            "address": "3298 Lewis Street Downers Grove",
            "price": "19.49",
            "thumbnail": "assets/img/tmp/listing-14.jpg",
            "verified": true,
            "latitude": 47.558519,
            "longitude": -122.212379
            }
            ,
            {
            "id": 15,
            "title": "Royal Hall",
            "address": "3690 Tecumsah Lane Cedar Rapids",
            "price": "42.43",
            "thumbnail": "assets/img/tmp/listing-15.jpg",
            "verified": false,
            "latitude": 47.54915,
            "longitude": -122.186984
            }
            ,
            {
            "id": 16,
            "title": "Tower Excursion",
            "address": "1081 Woodside Circle Crestview",
            "price": "65.49",
            "thumbnail": "assets/img/tmp/listing-16.jpg",
            "verified": true,
            "latitude": 47.581021,
            "longitude": -122.38337
            }
            ,
            {
            "id": 17,
            "title": "Medieval Castle",
            "address": "4323 Wilkinson Court Fort Myers Beach",
            "price": "348.00",
            "thumbnail": "assets/img/tmp/listing-17.jpg",
            "verified": false,
            "latitude": 47.624969,
            "longitude": -122.19528
            }
            ,
            {
            "id": 18,
            "title": "Steak House",
            "address": "1122 Wilkinson Court Naples",
            "price": "9.90",
            "thumbnail": "assets/img/tmp/listing-18.jpg",
            "verified": false,
            "latitude": 47.653701,
            "longitude": -122.166476
            }
            ,
            {
            "id": 19,
            "title": "Coffee Shop",
            "address": "3006 Par Drive Santa Monica",
            "price": "false",
            "thumbnail": "assets/img/tmp/listing-19.jpg",
            "verified": true,
            "latitude": 47.610668,
            "longitude": -122.185702
            }
            ,
            {
            "id": 20,
            "title": "Tasty Pizza Restaurant",
            "address": "2653 Cost Avenue College Park",
            "price": "83.92",
            "thumbnail": "assets/img/tmp/listing-20.jpg",
            "verified": true,
            "latitude": 47.576865,
            "longitude": -122.152056
            }
            ,
            {
            "id": 21,
            "title": "Sushi Bar",
            "address": "2464 Par Drive Los Angeles",
            "price": "934.00",
            "thumbnail": "assets/img/tmp/listing-21.jpg",
            "verified": false,
            "latitude": 47.59238,
            "longitude": -122.208018
            }
            ,
            {
            "id": 22,
            "title": "Freelance Office",
            "address": "4458 Thompson Drive Richmond",
            "price": "37.90",
            "thumbnail": "assets/img/tmp/listing-22.jpg",
            "verified": false,
            "latitude": 47.640301,
            "longitude": -122.321014
            }
            ,
            {
            "id": 23,
            "title": "Village Park",
            "address": "712 Ocala Street Kissimmee",
            "price": "93.00",
            "thumbnail": "assets/img/tmp/listing-23.jpg",
            "verified": true,
            "latitude": 47.553713,
            "longitude": -122.283592
            }
            ,
            {
            "id": 24,
            "title": "Little Tavern",
            "address": "2164 Hilltop Haven Drive Newark",
            "price": "923.00",
            "thumbnail": "assets/img/tmp/listing-24.jpg",
            "verified": true,
            "latitude": 47.536564,
            "longitude": -122.232437
            }
            ,
            {
            "id": 25,
            "title": "Ideal Garden Maintenance",
            "address": "2813 Preston Street Wichita",
            "price": "false",
            "thumbnail": "assets/img/tmp/listing-1.jpg",
            "verified": true,
            "latitude": 47.63845,
            "longitude": -122.404441
            }
            ,
            {
            "id": 26,
            "title": "Griffs Hamburgers",
            "address": "3228 Hillview Street Columbia",
            "price": "92.00",
            "thumbnail": "assets/img/tmp/listing-2.jpg",
            "verified": true,
            "latitude": 47.568309,
            "longitude": -122.335777
            }
            ,
            {
            "id": 27,
            "title": "Erb Lumber",
            "address": "2155 Philli Lane Mcalester",
            "price": "76.90",
            "thumbnail": "assets/img/tmp/listing-3.jpg",
            "verified": false,
            "latitude": 47.565529,
            "longitude": -122.377319
            }
            ,
            {
            "id": 28,
            "title": "Custom Lawn Care",
            "address": "2287 Maple Avenue Stockton",
            "price": "302.00",
            "thumbnail": "assets/img/tmp/listing-4.jpg",
            "verified": true,
            "latitude": 47.647934,
            "longitude": -122.337837
            }
            ,
            {
            "id": 29,
            "title": "Lafayette Radio",
            "address": "2374 Lucy Lane Evansville",
            "price": "20.90",
            "thumbnail": "assets/img/tmp/listing-5.jpg",
            "verified": true,
            "latitude": 47.623642,
            "longitude": -122.365989
            }
            ,
            {
            "id": 30,
            "title": "Wild Oats Markets",
            "address": "2906 Flanigan Oaks Drive Hagerstown",
            "price": "921.49",
            "thumbnail": "assets/img/tmp/listing-6.jpg",
            "verified": false,
            "latitude": 47.608536,
            "longitude": -122.337828
            }
        ]';

        DB::table('listings')->delete();

        $data = json_decode($propertyJsonData);
        $bhks = ['1 RK', '1 BHK', '2 BHK','3 BHK','3+ BHK'];
        $furnishings = ['Fully Furnished', 'Semi furnished', 'Unfurnished'];
        $propertyTypes = ['Apartment','Independent house','Independent floor','Studio Duplex','Penthouse','Villa'];
        
        $i = 0;
        foreach ($data as $obj) {
            // for (let i = 0; i < 20; i++) {
            //   if (i % 2 === 0) {
            //     points.push({
            //       latitude: 30.705080 + i * 0.001,
            //       longitude: 76.762020 + i * 0.001
            //     });
            //   } else {
            //     points.push({
            //       latitude: 30.705080 - i * 0.002,
            //       longitude: 76.762020 + i * 0.001
            //     });
            //   }
            // }

            $latitude = 30.705080 + $i * 0.001;
            $longitude = 76.762020 + $i * 0.001;

            $rating = new willvincent\Rateable\Rating;
            $rating->rating = rand(1,5);
            $rating->user_id = 1;
            $rating->review = "Test...";
            $listing = App\Listing::create(array(
                'id' => $obj->id,
                'title' => $obj->title,
                'addressLineOne'  => $obj->address,
                'addressLineTwo'  => '',
                'city'  => 'Chandigarh',
                'state'  => 'Chandigarh',
                'country'  => 'India',
                'pincode'  => 12121,
                'latitude'  =>  $latitude,
                'longitude'  => $longitude,
                // 'thumbnail'  => $obj->thumbnail,
                'price'  => $obj->price && $obj->price!= 'false'? (float)$obj->price: 0,
                'user_id'  => App\User::where('role', 'agent')->orWhere('role', 'owner')->pluck('id')->random(),
                'category_id' => App\Category::whereNotIn('name', ['residential', 'commercial'])->pluck('id')->random(),
                'bhk' => $bhks[array_rand($bhks)],
                'furnishing' => $furnishings[array_rand($furnishings)],
                'property_type' => $propertyTypes[array_rand($propertyTypes)],
            ));
            $listing->ratings()->save($rating);
            $i = $i + 1;
        }
    }
}
