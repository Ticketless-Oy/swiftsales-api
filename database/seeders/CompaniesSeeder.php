<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the companies seeder.
     *
     * @return void
     */
    public function run()
    {
        Company::factory()->count(20)->create();
    }
}
