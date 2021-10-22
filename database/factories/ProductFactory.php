<?php

namespace Database\Factories;

use App\Models\Product;
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
        return [
            'name'        => $this->faker->word(3, true),
            'slug'        => $this->faker->slug(),
            'description' => $this->faker->text(100),
            'price'       => $this->faker->randomFloat(2, 1000, 10000),
            'image'       => $this->faker->imageUrl(88, 600),
            // 'user_id'     => $this->faker->randomNumber(1, 99),
            'user_id'     => 5 // ใน heroku ไม่สามรถรัน id ได้
        ];
    }
}
