<?php

use Illuminate\Database\Seeder;

class AmountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('amounts')->insert([
            [//もう終わってる
                'amount' => 400,
                'lend_provider_user_id' => 2,
                'borrow_provider_user_id' => 1,
                'groupID' => 'dioshv',
                'payed' => false,
                'content' => 'test。'
            ],
    ]);
    }
}
