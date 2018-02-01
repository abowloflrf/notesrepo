<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //添加测试账号
        DB::table('users')->insert([
            'name' => 'ruofeng',
            'email' => 'lrf0829@126.com',
            'password' => bcrypt('notesrepo'),
        ]);
        //添加其他账号
        DB::table('users')->insert([
            'name' => '若风',
            'email' => 'i@ruofeng.me',
            'password' => bcrypt('notesrepo'),
        ]);
    }
}
