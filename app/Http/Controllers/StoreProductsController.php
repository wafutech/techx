<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StoreProduct;
use App\StoreProductCategory;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;

class StoreProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = StoreProduct::orderBy('sponsored','asc')->orderBy('downloads','desc')->orderBy('rating','desc')->get();
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
                'product_title'=>'required|string',
                'product_category_id'=>'required',
                'short_desc' => 'required|max:255',
                'detail_desc' =>'required',
                'vendor_id'=>'required',
                'product_image'=>'required|image|mimes:jpeg,jpg,png,gif|size:1024',
                'demo_video'=>'video',
                'developer_website'=>'url',
                'price'=>'required|numeric',
                'currency'=>'required|string',
                'product_file'=>'file|mimes:zip,PDF',

                'product_file'=>'required|url',
        ];

         $validator = Validator::make(Input::all(), $rules);
         if($validator->fails())
         {
            return $validator->messages();
         }

         //upload images and videos if any
          $image_path ='';
          $demo_video_path ='';
          $product_download_path ='';
          $product_file_size = ''

         if($request->hasFile('product_image')) 
         {
             
              
             $productImage = $request->file('product_image');
             $destination = 'images/products/'.Auth::User()->name;
             $size = $productImage->getSize();
             $ext = $productImage->getExtension();
             $fileName  = $request->product_title.Date('YMdhis');
             $fileName = $fileName.$ext;
            $image_path =$destination.'/'.$fileName.$ext;
            //Store the image in file storage
            $upload= $productImage->storeAs($destination, $fileName.".".$ext);
            if(!$upload)
            {
                return 'Something went wrong while uploading product image';
            }


         }

         if($request->hasFile('demo_video'))
         {

            $demoVideo = $request->file('demo_video');
             $destination = 'videos/products/'.Auth::User()->name;
             $size = $demoVideo->getSize();
             $ext = $demoVideo->getExtension();
             $fileName  = $request->product_title.Date('YMdhis');
             $fileName = $fileName.$ext;
            $demo_video_path =$destination.'/'.$fileName.$ext;
            //Store the image in file storage
            $upload= $demoVideo->storeAs($destination, $fileName.".".$ext);
            if(!$upload)
            {
                return 'Something went wrong while uploading product demo video';
            }
         }

          if($request->hasFile('product_file'))
         {

            $productFile = $request->file('product_file');
             $destination = 'downloads/products/'.Auth::User()->name;
             $product_file_size = $productFile->getSize();
             $ext = $productFile->getExtension();
             $fileName  = $request->product_title.Date('YMdhis');
             $fileName = $fileName.$ext;
            $product_download_path =$destination.'/'.$fileName.$ext;
            //Store the image in file storage
            $upload= $demoVideo->storeAs($destination, $fileName.".".$ext);
            if(!$upload)
            {
                return 'Something went wrong while uploading product product files';
            }
         }

         $product = new StoreProduct;
         $product->product_title = $request->product_title;
         $product->short_desc = $request->short_desc;
         $product->detail_desc = $request->detail_desc;
         $product->product_image = $request->product_image;
         $product->demo_video = $request->demo_video;
         $product->download_file_size = $request->$product_file_size;
         $product->sponsored = $request->sponsored;
         $product->price = $request->price;
         $product->currency = $request->currency;
         $product->developer_website = $request->developer_website;
         $product->downloads = 0;
         $product->product_category_id = $request->product_category_id;
         $product->vendor_id = $request->vendor_id;
         $product->save();


           
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = StoreProduct::findOrFail($id);
        return $product;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = StoreProduct::findOrFail($id);
        return $product;
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
        $product = StoreProduct::findOrFail($id);
        return $product->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = StoreProduct::findOrFail($id);
        return $product->delete();
    }
}
