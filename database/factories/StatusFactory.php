<?php

use Faker\Generator as Faker;

//生成对应 statuses 表的假数据

$factory->define(\App\Models\Status::class, function (Faker $faker) {
    $date_time = $faker->date . ' '. $faker->time;

    return [
        'content' => $faker->text(),
        'created_at' => $date_time,
        'updated_at' => $date_time
    ];
});
