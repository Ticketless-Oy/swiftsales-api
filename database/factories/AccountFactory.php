<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create('fi_FI');

        $CaccountName = $faker->company;
        $licenseType = $faker->randomElement(['basic', 'pro']);

        return [
            'accountName' => $CaccountName,
            'licenseType' => $licenseType
        ];
    }
}
