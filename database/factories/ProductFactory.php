<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $images = array('1.jpg', '2.jpg', '3.jpg');
        $key = array_rand($images);

        return [
            'name'        => $this->faker->word,
            'description' =>  $this->faker->paragraph(1),
            'quantity'    => $this->faker->numberBetween(1, 10),
            'status'      => rand(0, 1) ? Product::AVAILABLE_PRODUCT : Product::UNAVAILABLE_PRODUCT,
            'image'       => $images[$key],
            'seller_id'   => User::all()->random()->id,
            //or User::inRandomOrder()->first()->id
        ];
    }
}
