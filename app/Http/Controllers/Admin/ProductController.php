<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Contracts\ProductServiceInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends BaseController
{
    private $ps;
    
    public function __construct(ProductServiceInterface $prodserv) {
        Parent::__construct();
        $this->ps = $prodserv;
    }
    
    public function productList() {
        $this->data['products'] = $this->ps->getList();
        
        return view('admin.product.list', ['data' => $this->data]);
    }
    
    public function productCategories() {
        
        $this->data['product_categories'] = $this->ps->getProductCategories();
        
        return view('admin.product.categories', ['data' => $this->data]);
    }
    
    public function getProductById($id=""){
        $this->data['product_categories'] = $this->ps->getProductCategories();
        if(isset($id) && $id > 0){
            $this->data['product_detail'] = $this->ps->getDetailById($id);
//            dd($this->data['product_detail']->toArray());
        }
        
        return view('admin.product.detail', ['data' => $this->data]);
    }
    
    public function upsertProduct(Request $request){
        $inputs = $request->input('product');
        $inputs['slug'] = Str::slug($inputs['name']);
        if($request->hasFile('product.image')){ 
            $image = $request->file('product.image');
            $inputs['image'] = $image;
        }
//        dd($inputs);
        $validator = $this->productUpsertValidate($inputs, $inputs['id']);
        
        if ($validator->passes()) {
            $product = $this->ps->upsertProduct($inputs);
            if(isset($image)){
                $img_response = $this->ps->uploadImages($image, $product->id);
                return redirect()->route('product.list' )->with('message', 'Product Saved '.$product->name.
                        ' with '.count($img_response).' images');
            }
            return redirect()->route('product.list' )->with('error', 'Product Saved '.$product->name.' without images');
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
    
    public function getProductCategoryById($id=""){
        $this->data['product_category_detail'] = [];
        if(isset($id) && $id > 0){
            $this->data['product_category_detail'] = $this->ps->getProductCategoryById($id);
//            dd($this->data['product_category_detail']->toArray());
        }
        
        return view('admin.product.categorydetail', ['data' => $this->data]);
    }
    
    public function upsertProductCategory(Request $req){
        $inputs = $req->input('product');
        $validator = $this->productCatUpsertValidate($inputs);
        if ($validator->passes()) {
            $productCat = $this->ps->upsertProductCategory($inputs);
            return redirect()->route('product.categories' )->with('message', 'Product Saved '.$productCat->name);
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
    
    public function deleteProduct($id){
        
    }
    
    private function productUpsertValidate($inputs, $id=""){
        $validator = ['product_category_id' => 'required|integer','available' => 'required|integer','featured' => 'required|integer',
            'price' => 'required|numeric','discount' => 'required|numeric','description' => 'required|max:150',
            'image' => 'required|max:2048','name' => 'required|max:50', 'slug' => 'required|unique:products,slug'
        ];
        if($id==""){
            $validator['name'] = 'required|max:50|unique:products,name';
            $messages['name.unique'] = 'Product name must be unique';
        }
        $messages = [
            'name.required' => 'Please provide your name',
            'name.max' => 'maximum 50 charactes are allowed',
            'product_category_id.required' => 'Please select product category',
            'available.required' => 'Please select the number of available products',
            'featured.required' => 'Please select if product is featured',
            'price.required' => 'Price is required',
            'discount.required' => 'Discount is required',
            'price.numeric' => 'Please provide a valid price',
            'discount.numeric' => 'Please provide a valid discount',
            'description.required' => 'Please write a short description about the product.',
            'description.max' => 'maximum 150 charactes are allowed in description',
            'image.required' => 'Image is required to save a product into the inventory',
            'image.max' => 'Maximum allowed filesize 2 MB'
        ];
        return Validator::make($inputs, $validator, $messages);
    }
    
    private function productCatUpsertValidate($inputs) {
        $validator = ['name' => 'required|max:50|unique:product_categories,name'];
        $messages = [
            'name.required' => 'Please provide your name',
            'name.max' => 'maximum 50 charactes are allowed',
        ];
        return Validator::make($inputs, $validator, $messages);
    }
}
