<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only('show');
        $this->middleware('can:view,seller')->only('show');

    }
    /**
     *
     * Display a listing of the resource.
     */
    public function index()
    {
        $sellers=Seller::has('products')->get();
        return $this->showall($sellers);
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $seller=Seller::has('products')->findOrFail($id);
        return $this->showone($seller);
    }


}
