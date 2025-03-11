<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'designation' => $this->faker->jobTitle(),
            'message' => $this->faker->paragraph(),
            'image' => $this->faker->imageUrl(100, 100, 'people', true, 'testimonial'),
            'rating' => $this->faker->numberBetween(3, 5),
            'status' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }
}
