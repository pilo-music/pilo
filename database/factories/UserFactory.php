<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(10),
            'level' => "user",
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'birth' => $this->faker->date,
            'gender' => $this->faker->numberBetween(1, 3),
            'pic' => $this->faker->imageUrl(300, 300),
            'password' => bcrypt("123456"),
            'status' => User::USER_STATUS_ACTIVE,
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
        ];
    }
}
