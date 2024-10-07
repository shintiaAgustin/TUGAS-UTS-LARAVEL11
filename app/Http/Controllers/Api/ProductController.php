<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       //get all character with relasi on table characters, levels and users
       $Products =product::with(['categorie']) ->latest()->paginate(5);


         //response
         $response = [
             'massage' => 'List all products',
             'data'    => $Products,
         ];

         return response()->json($response,200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        $validator = Validator::make($request->all(), [
            'categories_id' => 'required|integer',
            'product' => 'required|string|min:2|unique:products',
            'description' => 'required|string',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Jika validasi sukses, simpan produk baru
        $products = Product::create([
            'categories_id' => $request->categories_id,
            'product' => $request->product,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $image->hashName(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully',
            'data' => $products,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       //get all character with relasi on table characters, levels and users
       $Products = product::with (['categorie'])->find($id);


        //response
        $response = [
            'success'   => 'Detail Product',
            'data'      => $Products,
        ];


        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //find gameplay by ID
        $Products = product::find($id);


        if (isset($Products)) {


            //delete post
            $Products->delete();


            $response = [
                'success'   => 'Delete product Success',
            ];
            return response()->json($response, 200);


        } else {
            //jika data gameplay tidak ditemukan
            $response = [
                'success'   => 'Data product Not Found',
            ];


            return response()->json($response, 404);
        }

    }

    public function update(Request $request, string $id)
    {
         //define validation rules
         $validator = Validator::make($request->all(), [
            'categories_id' => 'required|integer',
            'product' => 'required|string|min:2|unique:products',
            'description' => 'required|string',
            'price' => 'required|integer',
            'stok' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);

        //check if validation fails
        if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
        }
if ($request->hasFile('image')) {
        //find level by ID
        $Products=product::find($id);


        //check if image is not empty
        if ($request->hasfile('image')){

            //uplod img
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            //delete old img
            Storage::delete('public/product',$image->hashName());

            $Products->update([
                'categories_id' => $request->categories_id,
                'product' => $request->product,
                'description' => $request->description,
                'price' => $request->price,
                'stok' => $request->stok,
                'image' =>$image->hashName(),
            ]);
        } else {
            $Products->update([
                'categories_id' => $request->categories_id,
                'product' => $request->product,
                'description' => $request->description,
                'price' => $request->price,
                'stok' => $request->stok,
            ]);
        }


            //response
            $response = [
                'success'   => 'Update product success',
                'massage' => 'update product succes',
                'data'      => $Products,
            ];


            return response()->json($response, 200);
            }
        }
}
