<?php

use App\Http\Controllers\Buyer\BuyerCategoryController;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyerSellerController;
use App\Http\Controllers\Buyer\BuyerTransactionController;
use App\Http\Controllers\Category\CategoryBuyerController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\CategoryProductController;
use App\Http\Controllers\Category\CategorySellerController;
use App\Http\Controllers\Category\CategoryTransactionController;

use App\Http\Controllers\Product\productBuyerController;
use App\Http\Controllers\Product\productBuyerTransactionController;
use App\Http\Controllers\Product\productCategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\productTransactionController;
use App\Http\Controllers\Seller\SellerBuyerController;
use App\Http\Controllers\Seller\SellerCategoryController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerTransactionController;
use App\Http\Controllers\Transaction\TransactionCategoryController;

use App\Http\Controllers\Transaction\TransactionSellerController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::name('me')->get('users/me', [UserController::class],'me');

Route::resource('users', UserController::class,['except'=>['create','edit']]);
Route::name('verify')->get('users/verify/{token}', [UserController::class, 'verify']);
Route::name('resend')->get('users/{user}/resend', [UserController::class, 'resend']);

//buyer
Route::resource('buyers', BuyerController::class,['only'=>['index','show']]);
Route::resource('buyers.transactions', BuyerTransactionController::class,['only'=>['index','show']]);
Route::resource('buyers.products', BuyerProductController::class,['only'=>['index','show']]);
Route::resource('buyers.sellers', BuyerSellerController::class,['only'=>['index','show']]);
Route::resource('buyers.categories', BuyerCategoryController::class,['only'=>['index','show']]);


//category
Route::resource('categories', CategoryController::class,['except'=>['create','edit']]);
Route::resource('categories.buyers', CategoryBuyerController::class,['except'=>['create','edit']]);
Route::resource('categories.transactions', CategoryTransactionController::class,['except'=>['create','edit']]);
Route::resource('categories.sellers', CategorySellerController::class,['except'=>['create','edit']]);
Route::resource('categories.products', CategoryProductController::class,['except'=>['create','edit']]);




Route::resource('products', ProductController::class, ['only' => ['index', 'show']]);
Route::resource('products.buyers', ProductBuyerController::class, ['only' => ['index']]);
Route::resource('products.categories', ProductCategoryController::class, ['only' => ['index', 'update', 'destroy']]);
Route::resource('products.transactions', ProductTransactionController::class, ['only' => ['index']]);
Route::resource('products.buyers.transactions', ProductBuyerTransactionController::class, ['only' => ['store']]);



Route::resource('sellers', SellerController::class, ['only' => ['index', 'show']]);
Route::resource('sellers.buyers', SellerBuyerController::class, ['only' => ['index']]);
Route::resource('sellers.products', SellerProductController::class, ['except' => ['create', 'show', 'edit']]);
Route::resource('sellers.categories', SellerCategoryController::class, ['only' => ['index']]);
Route::resource('sellers.transactions', SellerTransactionController::class, ['only' => ['index']]);


Route::resource('transactions.categories', TransactionCategoryController::class,['only'=>['index']]);
Route::resource('transactions.sellers', TransactionSellerController::class,['only'=>['index']]);

//Route::get('transactions.categories', [TransactionCategoryController::class, 'index']);


Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');




