<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = Account::all()->first();
        if (!$accounts) {
            return;
        }
        PaymentMethod::query()->delete();
        $accounts->paymentMethods()->createMany([
                [
                    'name' => 'Cash',
                    'type' => 'CASH',
                    'is_active_method' => true,
                ],
                [
                    'name' => 'Bank',
                    'type' => 'BANK',
                    'is_active_method' => true,
                ],
                [
                    'name' => 'Card',
                    'type' => 'CARD',
                    'is_active_method' => true,
                ],
                [
                    'name' => 'Mobile Payment',
                    'type' => 'MOBILE',
                    'is_active_method' => true,
                ],
                [
                    'name' => 'Other',
                    'type' => 'OTHER',
                    'is_active_method' => true,
                ],
            ]);
    }
}
