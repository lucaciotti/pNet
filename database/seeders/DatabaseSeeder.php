<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use TimoKoerber\LaravelJsonSeeder\JsonDatabaseSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // Get default limit
        $normalMemLimit = ini_get('memory_limit');
        var_dump($normalMemLimit);
        // Set new limit
        ini_set('memory_limit', '-1');

        //other code
        Model::unguard();
        $this->call(JsonDatabaseSeeder::class);
        Model::reguard();

        // Restore default limit
        ini_set('memory_limit', $normalMemLimit);
    }
}
