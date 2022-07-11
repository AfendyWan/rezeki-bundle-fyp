<?php

namespace App\Http\Controllers;

use App\Models\SaleItem;
use App\Models\SaleItemCategory;
use App\Models\SaleItemImage;
use App\Models\WishList;
use App\Models\WishListItem;
use App\Models\Cart; 
use App\Models\CartItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
class SaleItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
   
        $saleItem = SaleItem::orderBy('updated_at', 'DESC')->sortable()->paginate(10);
        //$saleItem = SaleItem::latest()->paginate(5);
        $saleItemCategory = SaleItemCategory::all();
        return view('dashboards.admins.manageSaleItems.index',compact('saleItem', 'saleItemCategory'))
            ->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryName = SaleItemCategory::select('name')->get();
        $brandList =  SaleItem::select('itemBrand')->distinct()->get();
   
        return view('dashboards.admins.manageSaleItems.create', compact('categoryName', 'brandList'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
    
        $request->validate([
            'name' => 'required|string|max:255|unique:sale_items,itemName',
            'description' => ['required', 'string', 'max:255'],
            'price' => 'regex:/^[0-9]*\.[0-9][0-9]$/',
            'stock' => ['required', 'numeric'],
            'category' => 'required',
            'size' => 'required',
            'color' => 'required',
            'brand' => 'required',
            'images' => 'required|max:6',
          //  'images' => 'required|mimes:png,jpg,jpeg|max:5'
        ]);
        
        $category = SaleItemCategory::where('name', $request->category)->first();
        // date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
        
        $saleItem = new SaleItem;
        $saleItem->itemName = $request->name;
        $saleItem->itemDescription = $request->description;
        $saleItem->itemPrice = $request->price;
        $saleItem->itemStock = $request->price;
        $saleItem->itemCategory = $category->id;
        $saleItem->itemSize = $request->size;
        $saleItem->itemColor = $request->color;
        $saleItem->itemBrand = $request->brand;
        $saleItem->itemPromotionPrice =  0.00;
        $saleItem->itemPromotionStatus =  0;
        $saleItem->itemActivationStatus = 1;
       
        $saleItem->save();
        //Save file within laravel
       if ($request->hasfile('images')) {
            $images = $request->file('images');
            foreach($images as $image) {
                $name = time() .'-'.$image->getClientOriginalName();

                //save to upload folder within the public
                $path = $image->storeAs('sale_item', $name, 'public');
                
                //Save to public folder
                //$path = $image->storeAs('public/', $name);
                SaleItemImage::create([
                    'sale_item_id' => $saleItem->id,
                    'sale_item_category_id' => $category->id,
                    'url' => '/storage/'.$path
                ]);
            }
       }
       
  
        //  SaleItem::create([
        //     'itemName' => $request->name,
        //     'itemDescription' => $request->description,
        //     'itemPrice' => $request->price,
        //     'itemStock' => $request->stock,
        //     'itemCategory' => $category->id,
        //     'itemPromotionStatus' => 0,
        //     'itemPromotionPrice' => 0.00,
        //     'itemActivationStatus' => 1,
        // ]);

        ///////////////////////Update quantity in category
        $updateCategoryQuantity = $category->quantity + 1;
        SaleItemCategory::where('name', $request->category)
        ->update([
            'quantity' => $updateCategoryQuantity,  
         ]);
        /////////////////////////////////////////////////


        //SaleItemCategory::create($request->all());
        return redirect()->route('manageSaleItems.index')
        ->with('success','New sale item created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleItem  $saleItem
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $saleItem  = SaleItem::find($id);
        $category = SaleItemCategory::where('id', $saleItem->itemCategory )->first();
        $firstSaleItemImage = SaleItemImage::where('sale_item_id', $id)->first();
        
        $allSaleItemImages = SaleItemImage::where('sale_item_id', $id)->get();
        return view('dashboards.admins.manageSaleItems.show', compact('category', 'firstSaleItemImage', 'allSaleItemImages'))->withSaleitem($saleItem);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleItem  $saleItem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $saleItemCategory = SaleItemCategory::all();
        $saleItem  = SaleItem::find($id);
        $brandList =  SaleItem::select('itemBrand')->distinct()->get();
        return view('dashboards.admins.manageSaleItems.edit', compact('saleItemCategory', 'brandList'))->withSaleitem($saleItem);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaleItem  $saleItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleItem $saleItem)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => ['required', 'string', 'max:255'],
            'size' => 'required',
            'color' => 'required',
            'brand' => 'required',
            'price' => 'regex:/^[0-9]*\.[0-9][0-9]$/',
            'stock' => ['required', 'numeric'],
            'category' => 'required',
            'images' => 'required|max:6',
        ]);

        $category = SaleItemCategory::where('name', $request->category)->first();
        
        SaleItem::where('id', $request->id)
        ->update([
               'itemName' => $request->name,
               'itemDescription' => $request->description,
               'itemColor' => $request->color,
               'itemSize' => $request->size,
               'itemBrand' => $request->brand,
               'itemPrice' => $request->price,
               'itemStock' => $request->stock,
               'itemCategory' => $category->id,
               'itemPromotionStatus' => 0,
               'itemPromotionPrice' => 0.00,
               'itemActivationStatus' => 1,
        ]);
    

        $allSaleItemImages = SaleItemImage::where('sale_item_id', $request->id)->get();
        
        //delete file within laravel and database
        foreach($allSaleItemImages as $i){
            $image = $i->url;
            unlink(public_path($image));
            $i->delete();
        }

        //Save file within laravel
       if ($request->hasfile('images')) {
            $images = $request->file('images');
            foreach($images as $image) {
                $name = time() .'-'.$image->getClientOriginalName();

                //save to upload folder within the public
                $path = $image->storeAs('sale_item', $name, 'public');
                
                //Save to public folder
                //$path = $image->storeAs('public/', $name);
                SaleItemImage::create([
                    'sale_item_id' => $request->id,
                    'sale_item_category_id' => $category->id,
                    'url' => '/storage/'.$path
                ]);
            }
       }

       return redirect()->route('manageSaleItems.index')
       ->with('success','Sale item edited successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaleItem  $saleItem
     * @return \Illuminate\Http\Response
     */
    public function  destroy($id)
    {
        $tempTotalPrice = 0.00;
        $tempQuantity = 0;
        $findSaleItem = SaleItem::find($id);
        
        $checkCart = Cart::where([
           ['cartStatus', '=', 1],
        ])->get();

        $checkCartItem = CartItem::where([
            ['sale_item_id', '=', $id],
        ])->get();

        foreach($checkCart as $c){
            foreach($checkCartItem as $s){
                if($c->id == $s->cart_id){
                    if($findSaleItem->itemPromotionStatus == 1){
                        $tempTotalPrice = ($findSaleItem->itemPromotionPrice) * $s->quantity;
                        $tempTotalPrice = $c->totalPrice - $tempTotalPrice;
                        $tempQuantity = $c->cartItemQuantity - $s->quantity;
                       
                        Cart::where([
                            ['id', '=', $c->id],
                        ])->update([
                            'totalPrice' => $tempTotalPrice,
                            'cartItemQuantity' => $tempQuantity
                        ]);
                    }else{
                        $tempTotalPrice = ($findSaleItem->itemPrice) * $s->quantity;
                        $tempTotalPrice = $c->totalPrice - $tempTotalPrice;
                        $tempQuantity = $c->cartItemQuantity - $s->quantity;
                        Cart::where([
                            ['id', '=',  $c->id],
                        ])->update([
                            'totalPrice' => $tempTotalPrice,
                            'cartItemQuantity' => $tempQuantity
                        ]);
                    }
                }   
            }
        }

      
        foreach($checkCart as $c){
            if($c->totalPrice == 0.00){
                $c->delete();
            }
        }
     
        $findSaleItem->delete();
        
        $allSaleItemImages = SaleItemImage::where('sale_item_id', $id)->get();
        
        //delete file within laravel and database
        foreach($allSaleItemImages as $i){
            $image = $i->url;
            unlink(public_path($image));
            $i->delete();
        }

       
        return redirect()->route('manageSaleItems.index')
                        ->with('success','Sale item deleted successfully');
    }

    //Edit promotion settings
    public function editPromotion($id)
    {
        $saleItem  = SaleItem::find($id);
        return view('dashboards.admins.manageSaleItems.editPromotion')->withSaleitem($saleItem);
    }

    public function updatePromotion(Request $request, $id)
    {
        $request->validate([
           
            'promotionPrice' => 'regex:/^[0-9]*\.[0-9][0-9]$/',
         
        ]);
        
        //split the promotion duration into start and end
        $splitPromotionDuration = explode(" ",$request->promotionDuration);
        
        SaleItem::where('id', $id)
        ->update([
               'itemPromotionStatus' => $request->promotionStatus,
               'itemPromotionPrice' => $request->promotionPrice,
               'itemPromotionStartDate' => $splitPromotionDuration[0],
               'itemPromotionEndDate' => $splitPromotionDuration[2],
        ]);
       
        return redirect()->route('manageSaleItems.show', $id)->with('success','Sale item promotion updated successfully.');
    }

    //Toggle activation status
    public function toggleActivationStatus($id)
    {
        $tempTotalPrice = 0.00;
        $tempQuantity = 0;
       
   
        $saleItem = SaleItem::where('id', $id)->first();
        
        $checkCart = Cart::where([
           ['cartStatus', '=', 1],
        ])->get();

        $checkCartItem = CartItem::where([
            ['sale_item_id', '=', $id],
        ])->get();

      
 
        if ($saleItem->itemActivationStatus == 1) {
            
        foreach($checkCart as $c){
            foreach($checkCartItem as $s){
                if($c->id == $s->cart_id){
                   
                    if($saleItem->itemPromotionStatus == 1){
                        $tempTotalPrice = ($saleItem->itemPromotionPrice) * $s->quantity;
                        $tempTotalPrice = $c->totalPrice - $tempTotalPrice;
                        $tempQuantity = $c->cartItemQuantity - $s->quantity;
                      
                        Cart::where([
                            ['id', '=', $c->id],
                        ])->update([
                            'totalPrice' => $tempTotalPrice,
                            'cartItemQuantity' => $tempQuantity
                        ]);
                        $s->delete();
                    }else{
                        $tempTotalPrice = ($saleItem->itemPrice) * $s->quantity;
                       
                        $tempTotalPrice = $c->totalPrice - $tempTotalPrice;
                        $tempQuantity = $c->cartItemQuantity - $s->quantity;
                        
                        Cart::where([
                            ['id', '=',  $c->id],
                        ])->update([
                            'totalPrice' => $tempTotalPrice,
                            'cartItemQuantity' => $tempQuantity
                        ]);
                        $s->delete();
                    }
                }   
            }
        }

            SaleItem::where('id', $id)
            ->update([
               'itemActivationStatus' => 0,
            ]);
            return redirect()->back()->with('success','Sale item deactivated successfully');  
        } else {
            SaleItem::where('id', $id)
            ->update([
               'itemActivationStatus' => 1,
            ]);
            return redirect()->back()->with('success','Sale item activated successfully');  
        }
    }

    public function userIndex($id)
    {
         $allSaleItem = DB::table('sale_items')
        ->join('sale_item_images', 'sale_items.id', '=', 'sale_item_images.sale_item_id')
        ->where('sale_items.itemCategory', $id)
        ->select('sale_item_images.*', 'sale_items.*') //clash column name, the 2nd one will be chosen
        ->groupby('sale_item_images.sale_item_id')
        ->get();
      
     
        $saleItemCategory = SaleItemCategory::where('id', $id)->first();
        
        return view('dashboards.users.manageSaleItems.index',compact('allSaleItem', 'saleItemCategory'));
            
    }

    public function userShowItem($id)
    {
        $saleItem  = SaleItem::find($id);
       
        $category = SaleItemCategory::where('id', $saleItem->itemCategory )->first();
        $firstSaleItemImage = SaleItemImage::where('sale_item_id', $id)->first();
        
        $allSaleItemImages = SaleItemImage::where('sale_item_id', $id)->get();


        $userID = auth()->user()->id;
        $wishList = WishList::where('userID', $userID)->first();
        if(!$wishList){
            $wishListItemStatus = 0;
           
            return view('dashboards.users.manageSaleItems.show', compact('category', 'firstSaleItemImage', 'allSaleItemImages', 'wishListItemStatus'))->withSaleitem($saleItem);
        }else{
            $wishListItem =  WishListItem::where([
                                ['wish_id', '=', $wishList->id],
                                ['sale_item_id', '=', $id],
                            ])->first();
            
            if(!$wishListItem){
                $wishListItemStatus = 0;
                return view('dashboards.users.manageSaleItems.show', compact('category', 'firstSaleItemImage', 'allSaleItemImages', 'wishListItemStatus'))->withSaleitem($saleItem);
            }else{
                $wishListItemStatus = 1;
                return view('dashboards.users.manageSaleItems.show', compact('category', 'firstSaleItemImage', 'allSaleItemImages', 'wishListItemStatus'))->withSaleitem($saleItem);
            }
        }
    }

    public function userShowPromotionList()
    {
        $promotionSaleItems  = SaleItem::where('itemPromotionStatus', 1)->get();
    
        $saleItemImage = DB::table('sale_item_images')
        ->join('sale_items', 'sale_item_images.sale_item_id', '=', 'sale_items.id')
        ->select('sale_item_images.*', 'sale_items.*')
        ->groupby('sale_item_images.sale_item_id')
        ->get();
       
        $allSaleItemImages =  SaleItemImage::select('sale_item_id')->distinct()->get();

        return view('dashboards.users.manageSaleItems.showPromotionList', compact('promotionSaleItems', 'saleItemImage'));
            
    }

    public function searchWithParams(Request $request){
       
        if($request->param1 == null){
            $request->param1="emptysearch";
        }
        return \Redirect::route('userSearchSaleItem', ['param1' => $request->param1]);
    }

    public function userSearchSaleItem(Request $request)
    {
        $saleItemImage = DB::table('sale_item_images')
        ->join('sale_items', 'sale_item_images.sale_item_id', '=', 'sale_items.id')
        ->where('sale_items.itemName', 'LIKE', '%'.$request->param1.'%')
        ->select('sale_item_images.*', 'sale_items.*')
        ->groupby('sale_item_images.sale_item_id')
        ->get();

        $messageNoResult = false;
        if($saleItemImage->isEmpty()){
            $messageNoResult = true;
           
            return view('dashboards.users.manageSaleItems.search', compact('saleItemImage', 'messageNoResult'));       
        }
        return view('dashboards.users.manageSaleItems.search', compact('saleItemImage', 'messageNoResult'));            
    }

}
