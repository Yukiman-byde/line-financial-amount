<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
            [//もう終わってる
                'name' => 'wahahaha',
                'provider' => 'line',
                'provided_user_id'    => 'dfsojkongvoj@',
                'avatar' => 'df@eripncohvjg',
            ],
    ]);
    }
}
