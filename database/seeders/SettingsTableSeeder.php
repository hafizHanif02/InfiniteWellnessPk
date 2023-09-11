<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Setting::create(['key' => 'app_name', 'value' => 'Infinitewellness']);
        Setting::create(['key' => 'app_logo', 'value' => 'logo.png']);
        Setting::create(['key' => 'company_name', 'value' => 'Infinitewellness']);
        Setting::create(['key' => 'current_currency', 'value' => 'pkr']);
        Setting::create(['key' => 'hospital_address', 'value' => '16/A saint Joseph Park']);
        Setting::create(['key' => 'hospital_email', 'value' => 'infinitewellness@contact.com']);
        Setting::create(['key' => 'hospital_phone', 'value' => '+929876543210']);
        Setting::create(['key' => 'hospital_from_day', 'value' => 'Mon to Fri']);
        Setting::create(['key' => 'hospital_from_time', 'value' => '9 AM to 9 PM']);
        Setting::create(['key' => 'country_code', 'value' => '+92']);
        Setting::create(['key' => 'country_name', 'value' => 'pakistan']);
    }
}
