<?php

use Illuminate\Database\Seeder;


class OrganizationTableSeeder extends Seeder {

    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table('activities')->delete();
        DB::table('organizations')->delete();

        $organizations = array(
            [
                'name' => 'Nepal Redcross Society',
                'slug' => 'nepal-redcross-society',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'profile_picture' => "/img/profiles/1_profile.jpg",
                'phone' => '1234567890',
                'email' => 'info@redcross.org',
                'address' => 'Kathmandu',
                'website' => 'http://redcross.org',
                'description' => ''
            ], [
                'name' => 'World Health Organization',
                'slug' => 'world-health-organization',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'profile_picture' => "/img/profiles/2_profile.jpg",
                'phone' => '4567890123',
                'email' => 'info@who.org',
                'address' => 'Kathmandu',
                'website' => 'http://who.org',
                'description' => ''
            ], [
                'name' => 'UNHCR',
                'slug' => 'unhcr',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'profile_picture' => "/img/profiles/3_profile.jpg",
                'phone' => '7890123456',
                'email' => 'info@unhcr.org',
                'address' => 'Kathmandu',
                'website' => 'http://leopackersbangalore.com',
                'description' => ''
            ], [
                'name' => 'ReNepal',
                'slug' => 'the-packers-and-movers-bangalore',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'profile_picture' => "/img/profiles/4_profile.jpg",
                'phone' => '7890123456',
                'email' => 'info@renepal.org',
                'address' => 'Kathmandu',
                'website' => 'http://www.example.org',
                'description' => ''
            ], [
                'name' => 'World Food Programme',
                'slug' => 'world-food-programme',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'profile_picture' => "/img/profiles/3_profile.jpg",
                'phone' => '5890123456',
                'email' => 'info@wfp.org',
                'address' => 'Kathmandu',
                'website' => 'http://wfp.org',
                'description' => ''
            ]

        );

        $activities = array(
            [
                'org_id' => 1,
                'name' => 'Relief effort in Gorkha',
                'description' => 'We have been organizing relief efforts in Gorkha.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        );

        DB::table('organizations')->insert($organizations);
        DB::table('activities')->insert($activities);
    }

}