<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Setting::create([
            'about_us' => 'This is a sample about us text for Fruit Hub.',
            'why_us' => 'We provide the freshest fruits directly to your doorstep.',
            'goal' => 'To be the leading fruit delivery service in the region.',
            'vision' => 'To be the leading fruit delivery service in the region.',
            'tax_percentage' => 5,
            'shipping_fees' => 10,
            'welcome_text' => 'We deliver the best and freshest fruit salad in town. Order for a combo today!!!',
            'home_text' => 'Discover a variety of fresh fruits at unbeatable prices. Enjoy seamless shopping and fast delivery with Fruit Hub.',
            'success_text' => 'Your order have been taken and is being attended to.',
            'contact_us_text' => 'For inquiries, please reach out to us at',
            'terms_text' => 'By using our service, you agree to our terms and conditions.',
            'phone1' => '+201234567890',
            'phone2' => '+201287654321',
            'email' => 'info@fruithub.com',
            'facebook' => 'https://facebook.com/fruithub',
            'twitter' => 'https://twitter.com/fruithub',
            'instagram' => 'https://instagram.com/fruithub',
            'linkedin' => 'https://linkedin.com/company/fruithub',
            'youtube' => 'https://youtube.com/fruithub',
            
        ]);
    }
}
