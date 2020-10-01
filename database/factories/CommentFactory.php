<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fullname' => $this->faker->word,
            'body' => $this->faker ->paragraphs(2, true),
            'email' => $this->faker->email,
            'commentable_id' => $this->faker ->numberBetween(1, 11),
            'commentable_type' =>'App\Models\Post'
        ];
    }
}
