<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@stremvans.com'],
            [
                'name' => 'IT Administrator',
                'password' => Hash::make('admin12345'),
                'role' => 'admin',
                'status' => 'active'
            ]
        );

        User::updateOrCreate(
            ['email' => 'finance@stremvans.com'],
            [
                'name' => 'Finance Officer',
                'password' => Hash::make('finance123'),
                'role' => 'finance',
                'status' => 'active'
            ]
        );

        User::updateOrCreate(
            ['email' => 'compliance@stremvans.com'],
            [
                'name' => 'Compliance Officer',
                'password' => Hash::make('compliance123'),
                'role' => 'compliance',
                'status' => 'active'
            ]
        );

        User::updateOrCreate(
            ['email' => 'ro@stremvans.com'],
            [
                'name' => 'Relationship Officer',
                'password' => Hash::make('ro123456'),
                'role' => 'relationship_officer',
                'status' => 'active'
            ]
        );
    }
}