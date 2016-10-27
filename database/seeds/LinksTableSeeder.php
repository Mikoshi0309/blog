<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'link_name'=>'swj',
                'link_title'=>'你好帅',
                'link_url'=>'http://www.baidu.com',
                'link_order'=>1
            ],
            [
                'link_name'=>'chj',
                'link_title'=>'你好美',
                'link_url'=>'http://www.baidu.com',
                'link_order'=>2
            ],
        ];
        DB::table('links')->insert($data);
    }
}
