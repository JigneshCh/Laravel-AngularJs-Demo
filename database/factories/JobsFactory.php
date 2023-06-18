<?php

use Faker\Generator as Faker;

$factory->define(App\Jobs::class, function (Faker $faker) {
    return [
        'job_title' => $faker->jobTitle,
        'company_name' => $faker->company,
        'country' => $faker->country,
        'posted_date' => $faker->date,
        'experience' => $faker->numberBetween(0,10) . ' Year',
        'salary' => $faker->numberBetween(20000,160000),
        'description' => $faker->text(),
		'job_type' => $faker->randomElement(['part-time','full-time','hourly']),
    ];
});
