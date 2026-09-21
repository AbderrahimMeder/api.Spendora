<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\categories;
use App\Models\Budget;
use Illuminate\Support\Str;


class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $account = Account::first();

        if (!$account) {
            return;
        }

        $categories = categories::where('account_id', $account->id)
            ->whereIn('name', [
                'Food',
                'Transport',
                'Entertainment',
                'Bills',
            ])
            ->get()
            ->keyBy('name');

        $budgets = [
            [
                'category' => 'Food',
                'amount' => 2500,
            ],
            [
                'category' => 'Transport',
                'amount' => 1000,
            ],
            [
                'category' => 'Entertainment',
                'amount' => 800,
            ],
            [
                'category' => 'Bills',
                'amount' => 1500,
            ],
        ];

        foreach ($budgets as $budget) {
            $category = $categories->get($budget['category']);

            if (!$category) {
                continue;
            }

            Budget::create([
                'id' => (string) Str::uuid(),
                'account_id' => $account->id,
                'category_id' => $category->id,
                'amount' => $budget['amount'],
                'period' => 'MONTHLY',
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->endOfMonth(),
            ]);
        }
    }
}
