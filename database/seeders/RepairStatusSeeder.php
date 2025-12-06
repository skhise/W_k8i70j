<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepairStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['status_name' => 'New Inward', 'is_active' => true],
            ['status_name' => 'Repaired & Ready for Dispatch', 'is_active' => true],
        ];

        foreach ($statuses as $status) {
            DB::table('master_repairstatus')->insert([
                'status_name' => $status['status_name'],
                'is_active' => $status['is_active'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
