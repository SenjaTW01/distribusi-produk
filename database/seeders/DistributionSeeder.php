<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Distribution;
use App\Models\User;
use App\Models\Product;
use App\Models\DistributionDetail;
use Carbon\Carbon;

class DistributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $baristas = User::where('active', true)->get();
        $admin = User::where('active', true)->first(); // Asumsi ada setidaknya 1 admin

        if ($baristas->isEmpty() || !$admin) {
            $this->command->info('Please run UserSeeder first to create users and baristas.');
            return;
        }

        $products = Product::where('active', true)->get();
        if ($products->isEmpty()) {
            $this->command->info('Please run ProductSeeder first to create products.');
            return;
        }

        // Buat 15 data distribusi
        for ($i = 0; $i < 15; $i++) {
            $barista = $baristas->random();
            $notes = 'Distribusi rutin ' . ($i + 1);
            
            // Generate random date within the last 30 days
            $randomDate = Carbon::now()->subDays(rand(0, 29));

            $distribution = Distribution::create([
                'barista_id' => $barista->id,
                'total_qty' => 0, // Akan dihitung nanti
                'estimated_result' => 0, // Akan dihitung nanti
                'notes' => $notes,
                'created_by' => $admin->id,
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);

            $totalQty = 0;
            $estimatedResult = 0;
            $numProducts = rand(1, 5); // Setiap distribusi memiliki 1 sampai 5 produk

            for ($j = 0; $j < $numProducts; $j++) {
                $product = $products->random();
                $qty = rand(1, 10);
                $price = $product->price;
                $total = $qty * $price;

                DistributionDetail::create([
                    'distribution_id' => $distribution->id,
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'price' => $price,
                    'total' => $total,
                    'created_by' => $admin->id,
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate,
                ]);

                $totalQty += $qty;
                $estimatedResult += $total;
            }

            // Update total_qty and estimated_result in distribution
            $distribution->update([
                'total_qty' => $totalQty,
                'estimated_result' => $estimatedResult,
            ]);
        }

        $this->command->info('15 distributions have been seeded!');
    }
} 