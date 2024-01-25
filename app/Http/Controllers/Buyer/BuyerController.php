<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only('index');
        $this->middleware('can:view,buyer')->only('show');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buyers=Buyer::has('transactions')->get();
        return $this->showall($buyers);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buyer=Buyer::has('transaction')->findOrFail($id);
        return $this->showone($buyer);
    }




}
