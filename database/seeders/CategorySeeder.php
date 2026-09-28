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
                'category_color' => 'rgb(76, 175, 80,0.12)',
                'category_image' => 'Banknote',
            ],

            [
                'name' => 'Housing',
                'slug' => 'housing',
                'description' => 'Rent or mortgage',
                'type' => 'EXPENSE',
                'category_color' => 'rgb(244, 67, 54,0.12)',
                'category_image' => 'House',
            ],

            [
                'name' => 'Food',
                'slug' => 'food',
                'description' => 'Groceries and restaurants',
                'type' => 'EXPENSE',
                'category_color' => 'rgb(33, 150, 243,0.12)',
                'category_image' => 'Utensils',
            ],

            [
                'name' => 'Transport',
                'slug' => 'transport',
                'description' => 'Taxi, gas, public transport',
                'type' => 'EXPENSE',
                'category_color' => 'rgb(255, 152, 0,0.12)',
                'category_image' => 'Car',
            ],

            [
                'name' => 'Freelance',
                'slug' => 'freelance',
                'description' => 'Freelance income',
                'type' => 'INCOME',
                'category_color' => 'rgb(156, 39, 176,0.12)',
                'category_image' => 'BriefcaseBusiness',
            ],

            [
                'name' => 'Entertainment',
                'slug' => 'entertainment',
                'description' => 'Cinema, dining out, hobbies',
                'type' => 'EXPENSE',
                'category_color' => 'rgb(255, 193, 7,0.12)',
                'category_image' => 'Clapperboard',
            ],

            [
                'name' => 'Bills',
                'slug' => 'bills',
                'description' => 'Electricity, internet, phone',
                'type' => 'EXPENSE',
                'category_color' => 'rgb(96, 125, 139,0.12)',
                'category_image' => 'ReceiptText',
            ],

            [
                'name' => 'Other',
                'slug' => 'other',
                'description' => 'Miscellaneous',
                'type' => 'EXPENSE',
                'category_color' => 'Shuffle',
                'category_image' => 'rgb(0,0,0)',
            ],
        ];

        foreach ($categories as $category) {
            $category['account_id'] = $account->id;

            categories::create($category);
        }
    }
}