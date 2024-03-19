<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use App\Models\Company;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $faker = Faker::create('fi_FI');
        $firstName = $faker->firstName;
        $lastName = $faker->lastName;
        $email = iconv('UTF-8', 'ASCII//TRANSLIT', $firstName . '.' . $lastName . rand(0, 99) . '@swiftsales.fi');
        $phone = $faker->phoneNumber;

        $userID = User::all()->random()->userID;
        $companyID = Company::all()->random()->companyID;

        return [
            'userID' => $userID,
            'companyID' => $companyID,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'phone' => $phone,
        ];
    }
}
