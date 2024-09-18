<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppDownloadsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app_downloads')->delete();
        
        \DB::table('app_downloads')->insert(array (
            0 => 
            array (
                'appstore_url' => 'https://apps.apple.com/vn/app/market-online/id6472641956',
                'created_at' => '2023-10-12 11:43:01',
                'description' => NULL,
                'id' => 1,
                'playstore_url' => 'https://play.google.com/store/apps/details?id=io.actcms.spa.user',
                'provider_appstore_url' => 'https://apps.apple.com/vn/app/it-home-dịch-vụ-tại-nhà/id6484594491',
                'provider_playstore_url' => 'https://play.google.com/store/apps/details?id=io.actcms.spa.vendor',
                'title' => 'Play Store And App Store Url',
                'updated_at' => '2023-10-12 11:43:01',
            ),
        ));
        
        
    }
}