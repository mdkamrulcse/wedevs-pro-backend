<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the user
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'created_at' => Carbon::parse(date('Y-m-d H:i:s'))->format('Y-m-d H:i:s'),
        ]);
    }
}
