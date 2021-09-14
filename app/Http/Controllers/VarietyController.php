<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variety;
use App\Models\Brand;
use App\Models\Location;
use App\Models\Quality;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class VarietyController extends Controller
{
    public function index()
    {
        return Variety::all();
    }

    public function store(Request $request)
    {
        // Validate required fields (attributes) for Variety
        $validator = Validator::make(
            $request->all(),
            [
                'brand' => 'required',
                'location' => 'required',
                'quality' => 'required',
            ],
            ['required' => ':attribute is required!']
        );

        if ($validator->stopOnFirstFailure()->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        // Create/Fetch individual variety attributes
        $brand = Brand::firstOrCreate(['name' => $request->input('brand')]);
        $location = Location::firstOrCreate(['address' => $request->input('location')]);
        $quality = Quality::firstOrCreate(['name' => $request->input('quality')]);

        // Add only for unique variety attributes (brand, quality, location)
        $query = DB::table('varieties')->where('brand_id', '=', $brand->id)->where('location_id', '=', $location->id)->where('quality_id', '=', $quality->id)->get()->first();
        if($query)
            return response()->json(['error' => 'Variety for the location already exists with ID '.$query->id], 400);

        try {
            $variety = new Variety();
            $variety->brand_id = $brand->id;
            $variety->location_id = $location->id;
            $variety->quality_id = $quality->id;
            $variety->stock = $request->input('stock');
            $variety->price = $request->input('price');
            $variety->save();

            // return response with variety attributes' names
            return response()->json([
                'id' => $variety->id,
                'brand' => $brand->name,
                'location' => $location->address,
                'quality' => $quality->name,
                'stock' => $variety->stock,
                'price' => number_format($variety->price, 2),
                'created_at' => $variety->created_at->format("Y-m-d H:i:s"),
                'updated_at' => $variety->updated_at->format("Y-m-d H:i:s"),
            ], 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Error on insert'], 400);
        }
    }

    public function update(Request $request, $id)
    {
        // Check if variety exists. Send error if doesn't exist
        $variety = Variety::find($id);
        if($variety == null)
            return response()->json(['error' => 'Variety does not exist'], 400);

        // Create/Fetch individual variety attributes
        $brand = Brand::firstOrCreate(['name' => $request->input('brand')]);
        $location = Location::firstOrCreate(['address' => $request->input('location')]);
        $quality = Quality::firstOrCreate(['name' => $request->input('quality')]);

        $query = DB::table('varieties')->where('brand_id', '=', $brand->id)->where('location_id', '=', $location->id)->where('quality_id', '=', $quality->id)->get()->first();
        if($query)
            return response()->json(['error' => 'Variety for the location already exists with ID '.$query->id], 400);


        try {
            // Update variety
            $variety->brand_id = $brand->id;
            $variety->location_id = $location->id;
            $variety->quality_id = $quality->id;
            $variety->stock = $request->input('stock');
            $variety->price = $request->input('price');
            $variety->save();

            return response()->json([
                'id' => $variety->id,
                'brand' => $brand->name,
                'location' => $location->address,
                'quality' => $quality->name,
                'stock' => $variety->stock,
                'price' => number_format($variety->price, 2),
                'created_at' => $variety->created_at->format("Y-m-d H:i:s"),
                'updated_at' => $variety->updated_at->format("Y-m-d H:i:s"),
            ], 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Error on update.'], 500);
        }
    }

    public function search(Request $request)
    {
        if ($request->hasAny(['brand', 'location', 'quality'])) {
            try {
                $query = DB::table('varieties')->join('brands', 'brands.id', '=', 'varieties.brand_id')->join('locations', 'locations.id', '=', 'varieties.location_id')->join('qualities', 'qualities.id', '=', 'varieties.quality_id');
                if ($request->filled('brand')) {
                    $query = $query->where('brands.name', '=', $request->get('brand'));
                }
                if ($request->filled('location')) {
                    $query = $query->where('locations.address', '=', $request->get('location'));
                }
                if ($request->filled('quality')) {
                    $query = $query->where('qualities.name', '=', $request->get('quality'));
                }
                return $query->select('varieties.id as id', 'brands.name as brand', 'locations.address as location', 'qualities.name as quality', 'stock', 'price', 'varieties.created_at as created_at', 'varieties.updated_at as updated_at')->get();
            } catch (QueryException $e) {
                return response()->json(['error' => 'Error in searching'], 500);
            }
        } else {
            return response()->json(['error' => 'No input provided.'], 200);
        }
    }
}
