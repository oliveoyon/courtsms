<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DivisionDistrictSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // === Clean tables ===
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('districts')->truncate();
        DB::table('divisions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // === Divisions ===
        $divisions = [
            ['id' => 1, 'name_en' => 'Chattogram', 'name_bn' => 'চট্টগ্রাম', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name_en' => 'Rajshahi', 'name_bn' => 'রাজশাহী', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name_en' => 'Khulna', 'name_bn' => 'খুলনা', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'name_en' => 'Barishal', 'name_bn' => 'বরিশাল', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'name_en' => 'Sylhet', 'name_bn' => 'সিলেট', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'name_en' => 'Dhaka', 'name_bn' => 'ঢাকা', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7, 'name_en' => 'Rangpur', 'name_bn' => 'রংপুর', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8, 'name_en' => 'Mymensingh', 'name_bn' => 'ময়মনসিংহ', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('divisions')->insert($divisions);

        // === Districts per division ===
        $districts = [
            // Chattogram
            ['division_id' => 1, 'name_en' => 'Cumilla', 'name_bn' => 'কুমিল্লা', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 1, 'name_en' => 'Feni', 'name_bn' => 'ফেনী', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 1, 'name_en' => 'Brahmanbaria', 'name_bn' => 'ব্রাহ্মণবাড়িয়া', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 1, 'name_en' => 'Rangamati', 'name_bn' => 'রাঙ্গামাটি', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 1, 'name_en' => 'Noakhali', 'name_bn' => 'নোয়াখালী', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 1, 'name_en' => 'Chandpur', 'name_bn' => 'চাঁদপুর', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 1, 'name_en' => 'Lakshmipur', 'name_bn' => 'লক্ষ্মীপুর', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 1, 'name_en' => 'Chattogram', 'name_bn' => 'চট্টগ্রাম', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 1, 'name_en' => 'Cox\'s Bazar', 'name_bn' => 'কক্সবাজার', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 1, 'name_en' => 'Khagrachari', 'name_bn' => 'খাগড়াছড়ি', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 1, 'name_en' => 'Bandarban', 'name_bn' => 'বান্দরবান', 'created_at' => $now, 'updated_at' => $now],

            // Rajshahi
            ['division_id' => 2, 'name_en' => 'Sirajganj', 'name_bn' => 'সিরাজগঞ্জ', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 2, 'name_en' => 'Pabna', 'name_bn' => 'পাবনা', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 2, 'name_en' => 'Bogra', 'name_bn' => 'বগুড়া', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 2, 'name_en' => 'Rajshahi', 'name_bn' => 'রাজশাহী', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 2, 'name_en' => 'Natore', 'name_bn' => 'নাটোর', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 2, 'name_en' => 'Joypurhat', 'name_bn' => 'জয়পুরহাট', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 2, 'name_en' => 'Chapainawabganj', 'name_bn' => 'চাঁপাইনবাবগঞ্জ', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 2, 'name_en' => 'Naogaon', 'name_bn' => 'নওগাঁ', 'created_at' => $now, 'updated_at' => $now],

            // Khulna
            ['division_id' => 3, 'name_en' => 'Jessore', 'name_bn' => 'যশোর', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 3, 'name_en' => 'Satkhira', 'name_bn' => 'সাতক্ষীরা', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 3, 'name_en' => 'Meherpur', 'name_bn' => 'মেহেরপুর', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 3, 'name_en' => 'Narail', 'name_bn' => 'নড়াইল', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 3, 'name_en' => 'Chuadanga', 'name_bn' => 'চুয়াডাঙ্গা', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 3, 'name_en' => 'Kushtia', 'name_bn' => 'কুষ্টিয়া', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 3, 'name_en' => 'Magura', 'name_bn' => 'মাগুরা', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 3, 'name_en' => 'Khulna', 'name_bn' => 'খুলনা', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 3, 'name_en' => 'Bagerhat', 'name_bn' => 'বাগেরহাট', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 3, 'name_en' => 'Jhenaidah', 'name_bn' => 'ঝিনাইদহ', 'created_at' => $now, 'updated_at' => $now],

            // Barishal
            ['division_id' => 4, 'name_en' => 'Jhalokathi', 'name_bn' => 'ঝালকাঠি', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 4, 'name_en' => 'Patuakhali', 'name_bn' => 'পটুয়াখালী', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 4, 'name_en' => 'Pirojpur', 'name_bn' => 'পিরোজপুর', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 4, 'name_en' => 'Barishal', 'name_bn' => 'বরিশাল', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 4, 'name_en' => 'Bhola', 'name_bn' => 'ভোলা', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 4, 'name_en' => 'Barguna', 'name_bn' => 'বরগুনা', 'created_at' => $now, 'updated_at' => $now],

            // Sylhet
            ['division_id' => 5, 'name_en' => 'Sylhet', 'name_bn' => 'সিলেট', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 5, 'name_en' => 'Maulvibazar', 'name_bn' => 'মৌলভীবাজার', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 5, 'name_en' => 'Habiganj', 'name_bn' => 'হবিগঞ্জ', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 5, 'name_en' => 'Sunamganj', 'name_bn' => 'সুনামগঞ্জ', 'created_at' => $now, 'updated_at' => $now],

            // Dhaka
            ['division_id' => 6, 'name_en' => 'Narsingdi', 'name_bn' => 'নরসিংদী', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 6, 'name_en' => 'Gazipur', 'name_bn' => 'গাজীপুর', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 6, 'name_en' => 'Shariatpur', 'name_bn' => 'শরীয়তপুর', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 6, 'name_en' => 'Narayanganj', 'name_bn' => 'নারায়ণগঞ্জ', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 6, 'name_en' => 'Tangail', 'name_bn' => 'টাঙ্গাইল', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 6, 'name_en' => 'Kishoreganj', 'name_bn' => 'কিশোরগঞ্জ', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 6, 'name_en' => 'Manikganj', 'name_bn' => 'মানিকগঞ্জ', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 6, 'name_en' => 'Dhaka', 'name_bn' => 'ঢাকা', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 6, 'name_en' => 'Munshiganj', 'name_bn' => 'মুন্সীগঞ্জ', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 6, 'name_en' => 'Rajbari', 'name_bn' => 'রাজবাড়ী', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 6, 'name_en' => 'Madaripur', 'name_bn' => 'মাদারীপুর', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 6, 'name_en' => 'Gopalganj', 'name_bn' => 'গোপালগঞ্জ', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 6, 'name_en' => 'Faridpur', 'name_bn' => 'ফরিদপুর', 'created_at' => $now, 'updated_at' => $now],

            // Rangpur
            ['division_id' => 7, 'name_en' => 'Panchagarh', 'name_bn' => 'পঞ্চগড়', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 7, 'name_en' => 'Dinajpur', 'name_bn' => 'দিনাজপুর', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 7, 'name_en' => 'Lalmonirhat', 'name_bn' => 'লালমনিরহাট', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 7, 'name_en' => 'Nilphamari', 'name_bn' => 'নীলফামারী', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 7, 'name_en' => 'Gaibandha', 'name_bn' => 'গাইবান্ধা', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 7, 'name_en' => 'Thakurgaon', 'name_bn' => 'ঠাকুরগাঁও', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 7, 'name_en' => 'Rangpur', 'name_bn' => 'রংপুর', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 7, 'name_en' => 'Kurigram', 'name_bn' => 'কুড়িগ্রাম', 'created_at' => $now, 'updated_at' => $now],

            // Mymensingh
            ['division_id' => 8, 'name_en' => 'Sherpur', 'name_bn' => 'শেরপুর', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 8, 'name_en' => 'Mymensingh', 'name_bn' => 'ময়মনসিংহ', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 8, 'name_en' => 'Jamalpur', 'name_bn' => 'জামালপুর', 'created_at' => $now, 'updated_at' => $now],
            ['division_id' => 8, 'name_en' => 'Netrokona', 'name_bn' => 'নেত্রকোণা', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('districts')->insert($districts);
    }
}
