<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payment_methods = [
            'コンビニ払い',
            'カード支払い',
        ];
        foreach ($payment_methods as $name) {
            PaymentMethod::create(['name' => $name]);
        }
    }
}
