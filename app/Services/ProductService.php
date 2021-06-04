<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Contracts\ProductServiceInterface;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Image;
/**
 * Description of ProductService
 *
 * @author Ritobroto
 */
class ProductService implements ProductServiceInterface{
    
    public function getList($request=null) {
        $query = Product::with(['productImages', 'productCategory']);
        
        if(isset($request['search']) && $request['search'] != ""){
            $query = $query->where('name', 'LIKE', "%{$request['search']}%")->orWhere('description', 'LIKE', "%{$request['search']}%");
        }
        
        if(isset($request['product_category_id']) && ((int)$request['product_category_id']) > 0 ){
            $query = $query->where('product_category_id', (int)$request['product_category_id']);
        }
        $result = $query->orderBy('id','desc')->get();
        return $result;
    }
    
    public function getDetail($slug){
        $result = Product::with(['productImages', 
            'productCategory.product' => function($query){
                $query->orderBy('created_at', 'desc')->limit(4);
        }])->where('slug', $slug)->first();
        
        return $result;
    }
    
    public function getDetailById($id){
        $result = Product::with(['productImages', 'productCategory'])->where('id', $id)->first();
        
        return $result;
    }
    
    public function upsertProduct($inputs){
        
        $product = Product::updateOrCreate(
            ['id' => $inputs['id']],
            [
                'name' => $inputs['name'],'slug' => $inputs['slug'],
                'price' => $inputs['price'], 'discount' => $inputs['discount'], 'description' => $inputs['description'],
                'product_category_id' => $inputs['product_category_id'], 'featured' => $inputs['featured'], 'available' => $inputs['available']
            ]
        );
        return $product;
    }
    
    
    
    public function deleteProduct($id){
        
    }
    
    public function getProductCategories(){
        return ProductCategory::get();
    }
    
    public function getProductCategoryById($id){
        return ProductCategory::where('id', $id)->first();
    }
    
    public function upsertProductCategory($inputs) {
        $product = ProductCategory::updateOrCreate(
            ['id' => $inputs['id']],
            [
                'name' => $inputs['name']
            ]
        );
        return $product;
    }
    
    public function uploadImages($image, $prod_id) {
        $unique_id = uniqid($prod_id.'_', true);
        $extension = $image->getClientOriginalExtension();
        
        $obj['thb']['image_name'] = $image->getClientOriginalName();
        $obj['med']['image_name'] = $image->getClientOriginalName();
        $obj['thb']['product_id'] = $prod_id;
        $obj['med']['product_id'] = $prod_id;
        
//        dd($image->path());
        $destinationPath = public_path('assets'.'/images'.'/products');
        
        $this->createUpdateFolder($destinationPath, $prod_id);
        
        $img = Image::make($image->path());
        
        
        // saveing medium size
        $obj['med']['image_path'] = 'med_'.$unique_id.'.'.$extension;
        $obj['med']['image_size'] = 'med';
        
        $img->save($destinationPath.'/'.$prod_id.'/'.$obj['med']['image_path']);
        // saveing thumbnail size
        $obj['thb']['image_path'] = 'thb_'.$unique_id.'.'.$extension;
        $obj['thb']['image_size'] = 'thb';
        $img->orientate()->resize(100, 100, function ($constraint) {

            $constraint->aspectRatio();

        })->save($destinationPath.'/'.$prod_id.'/'.$obj['thb']['image_path']);
        
        
        return $this->saveImageInDB($prod_id, $obj);
    }
    
    private function saveImageInDB($pid,$input = array()){
        $return = [];
        ProductImage::where('product_id',$pid)->delete();
        foreach($input as $v){
            $return[] = ProductImage::create($v);
        }
        return $return;
    }
    
    private function createUpdateFolder($destinationPath, $prod_id){
        if(file_exists($destinationPath.'/'.$prod_id)){
            $files = glob($destinationPath.'/'.$prod_id.'/*'); // get all file names
            foreach($files as $file){ // iterate files
                if(is_file($file)) {
                    unlink($file); // delete file
                }
            }
        }
        if (!file_exists($destinationPath.'/'.$prod_id)) {
            mkdir($destinationPath.'/'.$prod_id, 0777, true);
        }
        
    }
    
}
