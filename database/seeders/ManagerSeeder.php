<?php


namespace Database\Seeders;

//use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dummy Manager
        Manager::create([
            'nama_lengkap' => 'Manager Example',
            'email' => 'manager@example.com',
            'nomor_telepon' => '081234567890',
            'departemen_id' => '1',
        ]);
    }
}
