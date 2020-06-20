<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name' => 'Plamen Penchev',
            'email' => 'plamen@example.com',
            'password' => Hash::make('12345678')
        ];
        User::insert($data);
    }
}
