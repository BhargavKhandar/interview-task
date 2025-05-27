<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $createMultipleClients = [
            ['name'=>'Acces Toyota','manufactuer'=>'Toyota', 'product_type' => "Oil", "price" => '50', "km" => '8000', "month" => '24', "vehicle_type" => 'Car / Small SUV'],
            ['name'=>'Action Cervolet','manufactuer'=>'Cervolet', 'product_type' => "Tier", "price" => '50', "km" => '', "month" => '', "vehicle_type" => 'Car / Small SUV'],
            ['name'=>'Ajax Mazda','manufactuer'=>'Mazda', 'product_type' => "Coolent", "price" => '50', "km" => '8000', "month" => '12', "vehicle_type" => 'Car / Midieum SUV'],
            ['name'=>'Amos Toyota','manufactuer'=>'Toyota', 'product_type' => "Brack ped", "price" => '50', "km" => '12000', "month" => '', "vehicle_type" => 'Car / Big SUV'],
            ['name'=>'Megtech','manufactuer'=>'Ature', 'product_type' => "Engine Oil", "price" => '50', "km" => '', "month" => '18', "vehicle_type" => 'Car / Small SUV'],
        ];
        
        Client::insert($createMultipleClients); // Eloquent
    }
}
