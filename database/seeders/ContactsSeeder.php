<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactsSeeder extends Seeder
{
    /**
     * Run the contacts seeder.
     *
     * @return void
     */
    public function run()
    {
        Contact::factory()->count(100)->create();
    }
}
