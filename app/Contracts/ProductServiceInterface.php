<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Contracts;

/**
 *
 * @author Ritobroto
 */
interface ProductServiceInterface {
    
    public function getList($request=null);
    
    public function getDetail($slug);
    
    public function getDetailById($id);
    
    public function upsertProduct($inputs);
    
    public function deleteProduct($id);
    
    public function getProductCategories();
    
    public function getProductCategoryById($id);
    
    public function uploadImages($file, $prod_id);
    
}
