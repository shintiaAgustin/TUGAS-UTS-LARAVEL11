<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Categorie;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */

    public function destroy(string $id)
    {
            //find level by ID
            $Categories = categories::find($id)->delete();


            $response = [
                'success'   => 'Delete categories Success',
            ];


            return response()->json($response, 200);
    }

     public function show(string $id)
{
        //find Level by ID
        $Categories = categorie::find($id);


        //response
        $response = [
            'success'   => 'Detail categories',
            'data'      => $Categories,
        ];


        return response()->json($response, 200);
}

     public function update(Request $request, string $id)
    {

        //define validation rules
        $validator = Validator::make($request->all(), [
        'categories' => 'required|unique:categories|min:2'

        ]);


        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        //find level by ID
        $Categories = categorie::find($id);


        $Categories->update([
            'categories'=> $request->categories,


        ]);


        //response
        $response = [
            'success'   => 'Update categories success',
            'data'      => $Categories,
        ];


        return response()->json($response, 200);
    }

    public function index()
    {
        //get all level
        $Categories = categorie::latest()->paginate(5);

        //response
        $response = [
            'massage' => 'List all categories',
            'data'    => $Categories,
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
      //validasi data
      $validator = Validator::make($request->all(),[
     'categories' => 'required|unique:categories|min:2',


    ]);


    //jika validasi gagal
    if ($validator->fails()) {
        return response()->json([
            'message' => 'Invalid field',
            'errors' => $validator->errors()
        ],422);
    }


    //jika validasi sukses masukan data level ke database
    $Categories = categorie::create([
        'categories' => $request->categories,
        'is_active' => $request->input('is_active', 1),
    ]);


    //response
    $response = [
        'success'   => 'Add categories success',
        'data'      => $Categories,
    ];


    return response()->json($response, 201);

    }
}
