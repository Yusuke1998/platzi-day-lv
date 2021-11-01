<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Jhonny Prz (ADMIN)',
            'email' => 'jhonny@jhonny.app',
            'email_verified_at' => now(),
            'password' => bcrypt('jhonny@jhonny.app')
        ]);
        
        factory(App\User::class, 50)->create();
    }
}
