<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder {
 
    public function run(): void {

        User::truncate();

        for ($i=10; $i<25; $i++) { 

            $nim = "1052220{$i}";
            
            User::create([
                'username' => $nim,
                'name' => "User {$nim}",
                'email' => "{$nim}@example.com",
                'password' => bcrypt('password'),
            ]);   
        }
    }
}
