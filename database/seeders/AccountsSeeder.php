<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountsSeeder extends Seeder
{
    /**
     * Run the accounts seeder.
     *
     * @return void
     */
    public function run()
    {
        Account::factory()->count(5)->create();
    }
}
