<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SaleItemImage;
use App\Models\SaleItemCategory;
use DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function index(){
      
        //group by also can be synonym as distinct, however,
        //$sale = SaleItemImage::select('url','sale_item_category_id')->groupBy('sale_item_category_id')->get(); invalid query unless strict in db change to false
        //$sale = SaleItemImage::select('sale_item_category_id')->groupBy('sale_item_category_id')->get();
        //dd(count($sale));


        //distinct value refer to sale_item_images.sale_item_id
        // $a = DB::table('sale_item_categories')->select('sale_item_categories.*')
        // ->join('sale_item_images', 'sale_item_categories.id', '=', 'sale_item_images.sale_item_id')
        // ->distinct()
        // ->get();

 
        $saleItemCatalogue = DB::table('sale_item_categories')
        ->join('sale_item_images', 'sale_item_categories.id', '=', 'sale_item_images.sale_item_category_id')
        ->select('sale_item_categories.*', 'sale_item_images.*')
        ->groupby('sale_item_images.sale_item_category_id')
        ->get();

     
        return view('dashboards.users.index', compact('saleItemCatalogue'));
    }
    
    function profile(){
        return view('dashboards.users.profile');
    }

    function settings(){
           return view('dashboards.users.settings');
    }
}
