<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the users seeder.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(10)->create();
        $this->createAdminUsers();
    }

    protected function createAdminUsers()
    {
        $swiftsalesAdminUsers = [
            [
                'accountID' => Account::all()->random()->accountID,
                'firstName' => 'Henri',
                'lastName' => 'Willman',
                'email' => 'henri.willman@swiftsales.fi',
                'password' => password_hash('test', PASSWORD_BCRYPT)
            ],
            [
                'accountID' => Account::all()->random()->accountID,
                'firstName' => 'Otto',
                'lastName' => 'Örn',
                'email' => 'otto.orn@swiftsales.fi',
                'password' => password_hash('test', PASSWORD_BCRYPT)
            ],
            [
                'accountID' => Account::all()->random()->accountID,
                'firstName' => 'Santeri',
                'lastName' => 'Pohjakallio',
                'email' => 'santeri.pohjakallio@swiftsales.fi',
                'password' => password_hash('test', PASSWORD_BCRYPT)
            ],
            [
                'accountID' => Account::all()->random()->accountID,
                'firstName' => 'Miska',
                'lastName' => 'Lampinen',
                'email' => 'miska.lampinen@swiftsales.fi',
                'password' => password_hash('test', PASSWORD_BCRYPT)

            ]
        ];

        foreach ($swiftsalesAdminUsers as $swiftsalesAdminUser) {
            User::create($swiftsalesAdminUser);
        }
    }
}
