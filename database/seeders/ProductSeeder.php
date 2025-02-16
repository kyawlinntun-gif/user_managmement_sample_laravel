<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Wireless Mouse', 'description' => 'A high-precision wireless mouse.', 'image' => '1739379536placeholder1.png'],
            ['name' => 'Mechanical Keyboard', 'description' => 'A durable keyboard with RGB lights.', 'image' => '1739379536placeholder2.png'],
            ['name' => 'Gaming Headset', 'description' => 'Noise-canceling headset with surround sound.', 'image' => '1739379536placeholder3.png'],
            ['name' => 'Smartphone Stand', 'description' => 'Adjustable stand for hands-free use.', 'image' => '1739379536placeholder4.png'],
            ['name' => 'Portable SSD', 'description' => 'External SSD with fast read/write speeds.', 'image' => '1739379536placeholder5.png'],
            ['name' => 'Wireless Charger', 'description' => 'Fast wireless charger for all devices.', 'image' => '1739379536placeholder6.png'],
            ['name' => 'Webcam 1080p', 'description' => 'HD webcam with autofocus and mic.', 'image' => '1739379536placeholder7.png'],
            ['name' => 'Bluetooth Speaker', 'description' => 'Compact speaker with deep bass.', 'image' => '1739379536placeholder8.png'],
        ];
        foreach ($products as $new_product) {
            $product = new Product();
            $product->name = $new_product['name'];
            $product->description = $new_product['description'];
            $product->image = $new_product['image'];
            $product->save();
        }
    }
}
