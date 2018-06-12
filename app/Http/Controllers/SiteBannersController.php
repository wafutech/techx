<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sitebanner;
use Redirect;

class SiteBannersController extends Controller
{
  public function __construct()
  {

    $this->middleware(['auth']);
  }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Sitebanner::all();
        return view('banners',['title'=>'Home Page Banners','banners'=>$banners]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.create',['title'=>'Add Home Page Banner']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
               $bannerbg ='';
               $bannerimg = '';
      if($request->hasFile('banner')) 
      {
        $banner = $request->file('banner');
        $bannerbg = $banner->store('public/images/homepage/banners');
        
         $bfname = $request->file('banner')->getClientOriginalName().date('his');


        //$request->image_file->move(public_path('images/homepage/banners'), $bfname);

        $background = $request->file('banner_image');
        $bannerimg = $background->store('public/images/homepage/banners/images');
        $bimgfname = $request->file('banner_image')->getClientOriginalName().date('his');
                //$request->image_file->move(public_path('images/homepage/banners/images'), $bimgfname);


         
      }

      $banner = new Sitebanner;
      $banner->banner = $bannerbg;
      $banner->banner_message = ucfirst($request->input('banner_message'));
      $banner->sub_title = ucfirst($request->input('sub_title'));
      $banner->banner_image = $bannerimg;
      $banner->save();

      return 'success';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Sitebanner::findOrFail($id);
        $banner->delete();
              return 'Banner  removed';


    }
}
