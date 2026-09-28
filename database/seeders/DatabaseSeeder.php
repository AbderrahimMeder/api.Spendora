<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    User::query()->delete();
    
    User::create([
            'name' => 'Abderrahim',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'ADMIN',
            'active' => true,
            'currency' => 'USD',
    ]);
    Account::query()->delete();
    Account::create([
        'user_id' => User::first()->id,
    ]);
    $this->call([
        CategorySeeder::class,
        PaymentMethodSeeder::class,
        TransactionSeeder::class,
        BudgetSeeder::class,
    ]);    
            
    }
}