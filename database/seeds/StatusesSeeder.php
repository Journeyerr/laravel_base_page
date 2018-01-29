<?php

use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * factories/StatusFactory.php  负责返回满足要求的数据
     * times 和 make 方法是由 FactoryBuilder 类 提供的 API。
     * times 接受一个参数用于指定要创建的模型数量，
     * make 方法调用后将为模型创建一个 集合。
     * php artisan db:seed --class=StatusesSeeder
     *
     * @return void
     */
    public function run()
    {
        $statuses = factory(\App\Models\Status::class)->times(100)->make();

        foreach ($statuses as $v) {
            $v->user_id = rand(1,3);
        }

        \App\Models\Status::insert($statuses->toArray());
    }
}
