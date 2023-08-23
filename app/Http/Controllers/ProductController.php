<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    function addProduct(Request $request)
    {   
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->file_path = $request->file('file')->store("public/products");        
        $product->save();
        return $product;
    }

    function list()
    {
        $products = Product::all();
        return $products;
    }

    function delete($id)
    {
        $delete = Product::where('id', $id)->delete();
        if ($delete) {
            return ["result" => "product has been deleted"];
        } else {
            return ["result" => "Operation failed to delete product"];
        }
 
    }

    function getProduct($id)
    {
        return Product::find($id);
    }

    function updateProduct(Request $request, $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
    
        if ($request->hasFile('file')) {
            // Update the file_path if a new file is provided
            $product->file_path = $request->file('file')->store("public/products");
        }
    
        $product->save();
    
        return $product;
    }

    function search($key) {
        $products = Product::where('name', 'Like', "%$key%")->get();
        return $products;
    }
    
}
