<?php

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //notes表结构
        // Schema::create('notes', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('uuid', 36)->unique();
        //     $table->string('author');
        //     $table->text('title');
        //     $table->text('content');
        //     $table->string('category',20);
        //     $table->timestamps();
        // });

        //给测试账号添加一篇Start目录的笔记
        $uuid = Uuid::uuid4()->toString();
        DB::table('notes')->insert([
            'uuid' => $uuid,
            'author' => 'lrf0829@126.com',
            'title' => str_random(12),
            'content' => str_random(100),
            'category' => 'Start'
        ]);
        //给测试账号添加4篇Test目录的笔记
        for($i = 1; $i <= 4; $i++){
            $uuid = Uuid::uuid4()->toString();
            DB::table('notes')->insert([
                'uuid' => $uuid,
                'author' => 'lrf0829@126.com',
                'title' => str_random(12),
                'content' => str_random(100),
                'category' => 'Test'
            ]);
        }
        //给另外账号添加一份笔记
        $uuid = Uuid::uuid4()->toString();
        DB::table('notes')->insert([
            'uuid' => $uuid,
            'author' => 'i@ruofeng.me',
            'title' => str_random(12),
            'content' => str_random(100),
            'category' => 'Test'
        ]);
    }
}
