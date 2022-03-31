<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement([
                'Nike','Addidas','Samsung','Nokia','Iphone','One+','Oppo','Coca Cola','Nivia','Ponds','Nova','Globe','Pldt','Bench','Hanabishi','Toyota',
                'Ferrari','Mazda','Kawasaki','Honda','Subaru'
            ]),
            'description' => $this->faker->text,
            'category_id' => Category::factory(),
            'date_added'  => now(),
            'user_id'     => 1
        ];
    }
}
