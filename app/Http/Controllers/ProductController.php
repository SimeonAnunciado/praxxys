<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //
        return response()->json([
            'type' => true,
            'data' => Product::orderBy('id','desc')->paginate(5)
        ]);
    }

    public function getCategory(){

        return response()->json([
            'type' => true,
            'data' => Product::distinct()->select('category')->get()
        ]);
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:products',
            'category' => 'required|unique:products',
            'description' => 'required',
        ]);

        $files = $request->attachments;

        foreach ($files as $file) {
           $file->store('products');
        }

        $datetime = Carbon::parse($request->datetime)->format('Y-m-d H:i:s');

        $create = Product::insert([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'datetime' => $datetime
        ]);

        return response()->json([
            'type' => $create ? 1 : 0,
            'data' => $create
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        return response()->json([
            'type' => true,
            'data' => $product
        ]);

    }


    public function filterCategory($category = '', $search = ''){

        $query = new Product;

        if($category != ''){
            $query = $query->where('category', $category);
        }

        if($search != '' ){
            $query->where('name', 'like', '%'.$search.'%');
            $query->OrWhere('description', 'like', '%'.$search.'%');
        }

        return response()->json([
            'type' => true,
            'data' => $query->paginate(5)
        ]);


    }



    public function search($keyword){

        $search = Product::where('name','like','%'.$keyword.'%')
        ->OrWhere('description','like','%'.$keyword.'%')
        ->paginate(5);


        return response()->json([
            'type' => true,
            'data' => $search
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $product = Product::find($id);
        return response()->json([
            'type' => $product !=null ? true : false,
            'data' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $files = $request->attachments;

        foreach ($files as $file) {
           $file->store('products');
        }

        $datetime = Carbon::parse($request->datetime)->format('Y-m-d H:i:s');

        $product = Product::where('id',$id)->update([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'datetime' => $datetime
        ]);


        return response()->json([
            'type' => $product ? 1 : 0,
            'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $product = Product::find($request->id);
        $isDeleted = $product->delete();

        return response()->json([
            'type' => $isDeleted ? true : false,
        ]);
    }
}
