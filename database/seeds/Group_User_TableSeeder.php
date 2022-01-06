<?php

use Illuminate\Database\Seeder;

class Group_User_TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_user')->insert([
            [//もう終わってる
                'user_id' => 1,
                'group_id' => 2,
            ],
      ]);
    }
}
