<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipPricesSeeder extends Seeder {
    public function run(): void {
        DB::table('corpo_membership_prices')->insert([
            ['activity_id' => 1, 'price' => 15000, 'valid_from' => '2025-01-01'],
            ['activity_id' => 2, 'price' => 18000, 'valid_from' => '2025-01-01'],
            ['activity_id' => 3, 'price' => 20000, 'valid_from' => '2025-01-01'],
            ['activity_id' => 4, 'price' => 25000, 'valid_from' => '2025-01-01'],
            ['activity_id' => 5, 'price' => 28000, 'valid_from' => '2025-01-01'],
            ['activity_id' => 6, 'price' => 30000, 'valid_from' => '2025-01-01'],
     
        ]);
    }
}
