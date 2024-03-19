<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AccountsSeeder::class,
            UsersSeeder::class,
            CompaniesSeeder::class,
            ContactsSeeder::class,
            LeadsSeeder::class,
            SalesAppointmentsSeeder::class,
        ]);
    }
}
