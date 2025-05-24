<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UpdateAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::where('email', 'admin@admin.com')->update([
            'is_admin' => true
        ]);
    }
} 