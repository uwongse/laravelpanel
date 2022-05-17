<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'last_login_at' => $faker->dateTime,
        
    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Actor::class, static function (Faker\Generator $faker) {
    return [
        'actor' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Cinema::class, static function (Faker\Generator $faker) {
    return [
        'cinema' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Director::class, static function (Faker\Generator $faker) {
    return [
        'director' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Movie::class, static function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'synopsis' => $faker->text(),
        'duration' => $faker->randomNumber(5),
        'poster' => $faker->sentence,
        'background' => $faker->sentence,
        'api_id' => $faker->date(),
        'trailer' => $faker->sentence,
        'type' => $faker->sentence,
        'premiere' => $faker->date(),
        'buy' => $faker->sentence,
        'active' => $faker->boolean(),
        'qualification_id' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Projection::class, static function (Faker\Generator $faker) {
    return [
        'hour' => $faker->sentence,
        'release_date' => $faker->sentence,
        'movie_id' => $faker->sentence,
        'room_id' => $faker->sentence,
        'cinema_id' => $faker->sentence,
        'syncronitation_id' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Qualification::class, static function (Faker\Generator $faker) {
    return [
        'qualification' => $faker->sentence,
        'abbreviation' => $faker->sentence,
        'image' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Room::class, static function (Faker\Generator $faker) {
    return [
        'room' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Slide::class, static function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'image' => $faker->sentence,
        'active' => $faker->boolean(),
        'updated' => $faker->dateTime,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Syncronitation::class, static function (Faker\Generator $faker) {
    return [
        'result' => $faker->text(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
        
        
    ];
});
