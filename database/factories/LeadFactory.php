<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use App\Models\Company;

class LeadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lead::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $faker = Faker::create('fi_FI');
        $name = $faker->sentence;
        $description = $faker->paragraph;
        $userID = User::all()->random()->userID;
        $companyID = Company::all()->random()->companyID;

        return [
            'userID' => $userID,
            'companyID' => $companyID,
            'name' => $name,
            'description' => $description,
        ];
    }
}
