<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\categories;
use App\Models\Transictions;
use App\Models\PaymentMethod;
class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Get first account
        $account = Account::first();

        if (!$account) {
            return;
        }
        Transictions::query()->delete();
        // Get categories of this account by slug
        $categories = categories::where('account_id', $account->id)
            ->get()
            ->keyBy('slug');
        $paymentMethods = PaymentMethod::where('account_id', $account->id)
            ->get()
            ->keyBy('type');
        $transactions = [
            [
                'account_id' => $account->id,
                'category_id' => $categories['salary']->id,
                'amount' => 6000.00,
                'title' => 'Monthly Salary',
                'type' => 'INCOME',
                'description' => 'Monthly salary',
                'date' => '2026-09-01',
                'currency' => 'MAD',
                'is_hidden' => false,
                'payment_method_id' => $paymentMethods['CASH']->id,
                'status' => 'COMPLETED',
            ],

            [
                'account_id' => $account->id,
                'category_id' => $categories['housing']->id,
                'amount' => 2500.00,
                'title' => 'Rent',
                'type' => 'EXPENSE',
                'description' => 'Monthly apartment rent',
                'date' => '2026-09-02',
                'is_hidden' => false,
                'currency' => 'MAD',
                'payment_method_id' => $paymentMethods['BANK']->id,
                'status' => 'COMPLETED',
            ],

            [
                'account_id' => $account->id,
                'category_id' => $categories['food']->id,
                'amount' => 800.00,
                'title' => 'Groceries',
                'type' => 'EXPENSE',
                'description' => 'Weekly groceries',
                'date' => '2026-09-03',
                'is_hidden' => false,
                'currency' => 'MAD',
                'payment_method_id' => $paymentMethods['CARD']->id,
                'status' => 'COMPLETED',
            ],

            [
                'account_id' => $account->id,
                'category_id' => $categories['transport']->id,
                'amount' => 300.00,
                'title' => 'Transportation',
                'type' => 'EXPENSE',
                'description' => 'Taxi and transportation',
                'date' => '2026-09-04',
                'is_hidden' => false,
                'currency' => 'MAD',
                'payment_method_id' => $paymentMethods['CASH']->id,
                'status' => 'COMPLETED',
            ],

            [
                'account_id' => $account->id,
                'category_id' => $categories['freelance']->id,
                'amount' => 1000.00,
                'title' => 'Freelance Project',
                'type' => 'INCOME',
                'description' => 'Payment for freelance project',
                'date' => '2026-09-05',
                'is_hidden' => false,
                'currency' => 'MAD',
                'payment_method_id' => $paymentMethods['BANK']->id,
                'status' => 'COMPLETED',
            ],

            [
                'account_id' => $account->id,
                'category_id' => $categories['entertainment']->id,
                'amount' => 450.00,
                'title' => 'Entertainment',
                'type' => 'EXPENSE',
                'description' => 'Cinema and activities',
                'date' => '2026-09-06',
                'is_hidden' => false,
                'currency' => 'MAD',
                'payment_method_id' => $paymentMethods['CARD']->id,
                'status' => 'COMPLETED',
            ],

            [
                'account_id' => $account->id,
                'category_id' => $categories['bills']->id,
                'amount' => 150.00,
                'title' => 'Internet Bill',
                'type' => 'EXPENSE',
                'description' => 'Monthly internet subscription',
                'date' => '2026-09-06',
                'is_hidden' => false,
                'currency' => 'MAD',
                'payment_method_id' => $paymentMethods['CARD']->id,
                'status' => 'COMPLETED',
            ],

            [
                'account_id' => $account->id,
                'category_id' => $categories['other']->id,
                'amount' => 500.00,
                'title' => 'Cashback',
                'type' => 'INCOME',
                'description' => 'Cashback received',
                'date' => '2026-09-07',
                'is_hidden' => false,
                'currency' => 'MAD',
                'payment_method_id' => $paymentMethods['CARD']->id,
                'status' => 'COMPLETED',
            ],
        ];

        foreach ($transactions as $transaction) {
            Transictions::create($transaction);
        }
    }
}
