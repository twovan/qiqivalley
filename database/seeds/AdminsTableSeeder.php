<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('admins')->insert([
            [
                'id' => '1',
                'username' => 'admin',
                'password' => '$2y$10$VrMVvT5LQlZ8aEkljJZhV.KROsYM1YlwiHI0taG/Qjkwl9M9B3pXm',
                'name' => 'admin',
                'status' => '1',
            ],
        ]);


    }
}
