<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * $ php artisan db:seed        运行所有数据填充
     * $ php artisan db:seed --class=UsersTableSeeder 单独指定执行 UserTableSeeder 数据库填充文件
     *
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Laravel 默认为我们定义了一个 DatabaseSeeder 类
         *
         * 使用 call 方法来运行其它的 Seeder 类，以此控制数据填充的顺序
         *
         * */

        \Illuminate\Database\Eloquent\Model::unguard();

        $this->call(UsersTablesSeeder::class);

        \Illuminate\Database\Eloquent\Model::reguard();
    }
}
