<?php

use Illuminate\Database\Seeder;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            [//もう終わってる
                'name' => 'dsifj[i0sj',
                'groupID' => 'df@dofuhjgidp[s.o@v',
                'pictureUrl' => null,
            ],
    ]);
    }
}
