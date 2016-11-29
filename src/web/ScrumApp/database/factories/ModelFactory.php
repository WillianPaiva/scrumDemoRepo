<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Project::class, function (Faker\Generator $faker) {
    static $password;

    $user = App\User::all()->pluck('id')->toArray();
    $lang = array('JavaScript', 'Java', 'PHP', 'Python', 'C', 'C++', 'Ruby', 'CSS', 'Objective-C');


    return [
        'name' => $faker->word,
        'user_id' => $user[array_rand($user)],
        'description' => $faker->paragraph,
        'language' => $lang[array_rand($lang)],
        'version' => $faker->randomDigit,
    ];
});
$factory->define(App\Flag::class,function(Faker\Generator $faker){
$colours=array('red','blue');
return [
'name'=>$faker->word,
'color'=>$colours[array_rand($colours)],
];
  });
$factory->define(App\Sprint::class,function(Faker\Generator $faker){
  $projects=App\Project::all()->pluck('id')->toArray();
  return [
    'name'=>$faker->word,
    'date_begin'=>$faker->date($format = 'Y-m-d', $max = 'now'),
    'date_estimated'=>$faker->date($format = 'Y-m-d', $max = 'now'),
    'project_id'=>$projects[array_rand($projects)],

  ];
});


$factory->define(App\UserStory::class,function(Faker\Generator $faker){
$projects=App\Project::all()->pluck('id')->toArray();
$status=array('TODO','DOING','DONE');
return[
  'description'=>$faker->paragraph,
  'status'=>$status[array_rand($status)],
  'commit'=>$faker->word,
  'date_begin'=>$faker->date($format = 'Y-m-d', $max = 'now'),
  'date_estimated'=>$faker->date($format = 'Y-m-d', $max = 'now'),
  'date_finished'=>$faker->date($format = 'Y-m-d', $max = 'now'),
  'effort'=>$faker->randomDigitNotNull,
  'priority'=>$faker->randomDigitNotNull,
  'project_id'=>$projects[array_rand($projects)],
];
  });

$factory ->define(App\Task::class,function(Faker\Generator $faker){
$user_stories=App\UserStory::all()->pluck('id')->toArray();
$status=array('TODO','DOING','DONE');
  return [
'name'=>$faker->word,
'description'=>$faker->paragraph,
'status'=>$status[array_rand($status)],
'commit'=>$faker->word,
'priority'=>$faker->randomDigitNotNull,
'cost'=>$faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
'date_begin'=>$faker->date($format = 'Y-m-d', $max = 'now'),
'date_estimated'=>$faker->date($format = 'Y-m-d', $max = 'now'),
'date_finished'=>$faker->date($format = 'Y-m-d', $max = 'now'),
  'user_story_id'=>$user_stories[array_rand($user_stories)],
  ];
});
$factory->define(App\Layout::class,function(Faker\Generator $faker){
$sprints=App\Sprint::all()->pluck('id')->toArray();
return [
  'name'=>$faker->name,
  'position'=>$faker->randomDigitNotNull,
  'sprint_id'=>$sprints[array_rand($sprints)]
];

});
