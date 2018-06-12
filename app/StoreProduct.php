<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreProduct extends Model
{
    protected $fillable =['product_title','short_desc','detail_desc','vendor_id','price','currency','product_image','demo_video','product_file','download_file_size','downloads','developer_website','product_category_id','sponsored'];

    public function productcategory()
    {

    return $this->belongsTo('App\StoreProductCategory');
    }

    public function vendor()
    {

    return $this->belongsTo('App\StoreVendor');
    }

    public function features()
    {
    	return $this->hasMany('App\StoreProductFeature');
    }

    public function orders()
    {
    	return $this->hasMany('App\StoreCustomerOrder');
    }
}
