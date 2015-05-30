<?php

use Illuminate\Database\Seeder;


class UserTableSeeder extends Seeder {

    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table('users')->delete();

        $users = array(
            [
                'id' => 1,
                'name' => 'Admin',
                'org_id' => 1,
                'email' => 'admin@example.org',
                'password' => Hash::make('admin'),
                'roles' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id' => 2,
                'name' => 'User',
                'org_id' => 2,
                'email' => 'user@example.org',
                'password' => Hash::make('user'),
                'roles' => 'user',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        );

        //// Uncomment the below to run the seeder
        DB::table('users')->insert($users);
    }

}