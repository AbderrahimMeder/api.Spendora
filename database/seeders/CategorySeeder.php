<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\categories;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $account = Account::first();

        if (!$account) {
            return;
        }
        categories::query()->delete();
        $categories = [
            [
                'name' => 'Salary',
                'slug' => 'salary',
                'description' => 'Monthly salary',
                'type' => 'INCOME',
                'category_color' => '#4CAF50',
                'category_image' => '💰',
            ],

            [
                'name' => 'Housing',
                'slug' => 'housing',
                'description' => 'Rent or mortgage',
                'type' => 'EXPENSE',
                'category_color' => '#f44336',
                'category_image' => '🏠',
            ],

            [
                'name' => 'Food',
                'slug' => 'food',
                'description' => 'Groceries and restaurants',
                'type' => 'EXPENSE',
                'category_color' => '#2196F3',
                'category_image' => '🍔',
            ],

            [
                'name' => 'Transport',
                'slug' => 'transport',
                'description' => 'Taxi, gas, public transport',
                'type' => 'EXPENSE',
                'category_color' => '#FF9800',
                'category_image' => '🚗',
            ],

            [
                'name' => 'Freelance',
                'slug' => 'freelance',
                'description' => 'Freelance income',
                'type' => 'INCOME',
                'category_color' => '#9C27B0',
                'category_image' => '💼',
            ],

            [
                'name' => 'Entertainment',
                'slug' => 'entertainment',
                'description' => 'Cinema, dining out, hobbies',
                'type' => 'EXPENSE',
                'category_color' => '#FFC107',
                'category_image' => '🎭',
            ],

            [
                'name' => 'Bills',
                'slug' => 'bills',
                'description' => 'Electricity, internet, phone',
                'type' => 'EXPENSE',
                'category_color' => '#FF5722',
                'category_image' => '🧾',
            ],

            [
                'name' => 'Other',
                'slug' => 'other',
                'description' => 'Miscellaneous',
                'type' => 'EXPENSE',
                'category_color' => '#607D8B',
                'category_image' => '🔀',
            ],
        ];

        foreach ($categories as $category) {
            $category['account_id'] = $account->id;

            categories::create($category);
        }
    }
}