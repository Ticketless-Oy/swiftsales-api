<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $faker = Faker::create('fi_FI');
        $companyName = $faker->company;
        $businessID = $faker->randomNumber(7);

        $userID = User::all()->random()->userID;

        return [
            'userID' => $userID,
            'companyName' => $companyName,
            'businessID' => $businessID,
        ];
    }
}
