<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    public function __construct()
    {

        $this->middleware('client.credentials')->only(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product=Product::all();
        return $this->showall($product);
    }





    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->showone($product);
    }


}
