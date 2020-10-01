<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $topic = $this->faker->word;

        return [
            'topic' => $topic,
            'body' => $this->faker ->paragraphs(2, true),
            'category_id' => $this->faker ->numberBetween(1, 10)
            ];
    }
}
