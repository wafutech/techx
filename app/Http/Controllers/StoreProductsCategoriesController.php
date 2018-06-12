<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StoreProductCategory;
use Auth;
use Validator;

class StoreProductsCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = StoreProductCategory::all();
        return $categories;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'product_category'=>'required|string|unique:store_products_categories',
            'description' => 'required|string',
            'icon'=>'required|image|mimes:jpg,jpeg,png',
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->messages();
        }

         $icon_path ='';//Store the path of the uploaded icon in the db

        if($request->hasFile('icon'))
        {
            $icon = $request->file('icon');
            //Extract file extension of the requested file
            $ext = $icon->getExtension();
            //File name bound to categoy name which is already unique
            $fileName = $request->product_category;
            //Cotecatenate file name to ext to build a valid image file
            $fileName = $fileName.$ext;
            //directory under which the file icon will be uploaded. This directory will be created if does not exist in public directory

            $destination = 'images/categories';
            //Build file path and then persist it into the dabase
            $icon_path = $destination.'/'.$fileName;
            //Now upload the file
              $upload= $icon->storeAs($destination, $fileName);
              //Return an exception if file upload failed
              if(!$upload)
              {
                    return 'Something went wrong while uploading category icon';
              }
              //Else proceed and save data into the database

              $category = new StoreProductCategory;
              $category->product_category= $request->product_category;
              $category->description = $request->description;
              $category->icon = $icon_path;
              $category->save();


        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = StoreProductCategory::findOrFail($id);
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $category = StoreProductCategory::findOrFail($id);
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $category = StoreProductCategory::findOrFail($id);
        return $category->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $category = StoreProductCategory::findOrFail($id);
        return $category->delete();
    }
}
