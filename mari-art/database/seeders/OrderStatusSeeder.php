<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'Не обработан', 'slug' => 'not_processed'],
            ['name' => 'Принят', 'slug' => 'accepted'],
            ['name' => 'В процессе', 'slug' => 'in_progress'],
            ['name' => 'Готов', 'slug' => 'completed'],
        ];

        foreach ($statuses as $status) {
            OrderStatus::create($status);
        }
    }
} 