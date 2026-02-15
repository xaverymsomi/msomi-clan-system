<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Flutterwave Default
        PaymentGateway::updateOrCreate(
            ['slug' => 'flutterwave'],
            [
                'name' => 'Flutterwave',
                'base_url' => 'https://api.flutterwave.com/v3',
                'api_key' => 'FLWPUBK_TEST-xxxxxxxxxxxxxxxxxxxx-X',
                'api_secret' => 'FLWSECK_TEST-xxxxxxxxxxxxxxxxxxxx-X',
                'is_active' => true,
                'settings' => [
                    'currency' => 'TZS',
                ]
            ]
        );

        // M-Pesa Template
        PaymentGateway::updateOrCreate(
            ['slug' => 'mpesa'],
            [
                'name' => 'M-Pesa (Vodacom)',
                'base_url' => 'https://api.safaricom.co.ke', // Example for Safaricom/Vodacom
                'api_key' => 'CONSUMER_KEY',
                'api_secret' => 'CONSUMER_SECRET',
                'is_active' => false,
                'settings' => [
                    'shortcode' => '174379',
                    'passkey' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
                ]
            ]
        );
    }
}
