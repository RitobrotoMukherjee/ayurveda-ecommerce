<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Contracts\ProductServiceInterface;

class ProductController extends BaseController
{
    private $ps;
    
    public function __construct(ProductServiceInterface $prodserv){
        Parent::__construct();
        
        $this->ps = $prodserv;
        
        $this->data['page'] = 'product';
    }
    
    public function getList(Request $request){
        $search = $request->all();
        $this->data['products'] = $this->ps->getList($search);
        
        return view('website.productlist', ['data' => $this->data]);
        
    }
    
    public function getDetail($slug){
        $this->data['product'] = $this->ps->getDetail($slug);
        $this->data['similar_product'] = $this->data['product']->productCategory->product;
//        dd($this->data['product']->toArray());
        
        return view('website.productdetail', ['data' => $this->data]);
    }
}
