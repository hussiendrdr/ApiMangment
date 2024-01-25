<?php

namespace Database\Factories;

use App\Models\Seller;
use App\Models\User;
use Database\Factories\Helpers\FactoryHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seller=rand(1,Seller::all()->count());
//        $seller=Seller::has('products')->get()->random();
//        $buyer=User::all()->except($seller->id)->random();

//        $seller=FactoryHelper::getRandomModelId(Seller::class);
        $buyer=User::all()->except($seller)->count();;
        $buyer1=rand(1, $buyer);


        return [
            'quantity'=>fake()->randomNumber(1,10),
            'buyer_id'=>$buyer1,
            'products_id'=>$seller
        ];
    }
}
