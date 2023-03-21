<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Webmapp',
            'email' => 'team@webmapp.it',
            'password' => bcrypt('webmapp'),
            'roles' => [UserRole::Admin]
        ])->markEmailAsVerified();

        User::factory()->create([
            'name' => 'Editor',
            'email' => 'editor@webmapp.it',
            'password' => bcrypt('webmapp'),
            'roles' => [UserRole::Editor]
        ])->markEmailAsVerified();

        User::factory()->create([
            'name' => 'Contributor',
            'email' => 'contributor@webmapp.it',
            'password' => bcrypt('webmapp'),
            'roles' => [UserRole::Contributor]
        ])->markEmailAsVerified();
    }
}
