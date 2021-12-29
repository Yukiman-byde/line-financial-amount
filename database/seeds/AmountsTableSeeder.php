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
                'amount' => 0,
                'lend_provider_user_id' => 'hsd@',
                'borrow_provider_user_id' => 'df@ojosv',
                'payed' => false,
                'content' => 'トイレ貸した分のお金。'
            ],
    ]);
    }
}
