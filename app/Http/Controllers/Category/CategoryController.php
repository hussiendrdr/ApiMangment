<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Transformers\CategoryTransformer;
use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    public function __construct()
    {

        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('transform.input:' . CategoryTransformer::class)->only(['store','update']);

    }

    public function index()
    {
        $categories = Category::all();


        return $this->showall($categories);

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules=[
            'name'=>'required',
            'description'=>'required'
        ];
        $this->validate($request, $rules);
        $newCategory=Category::create($request->all());
        return $this->showone($newCategory);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->showone($category);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $category->fill($request->only([
            'name',
            'description',

        ]));
        if ($category->isClean()){
            return $this->errorResponse('you need to specify any different value to update',422);
        }
        $category->save();
        return $this->showone($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
       $category->delete();
       return $this->showone($category);
    }
}
