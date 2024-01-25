<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;

use App\Models\Product;
use Illuminate\Http\Request;

class productBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        parent::__construct();
    }





    public function index(Product $product)
    {


        $buyers = $product->transactions()
            ->with('buyer')
            ->get()
            ->pluck('buyer')
            ->unique('id')
            ->values();

        return $this->showall($buyers);

}

}
