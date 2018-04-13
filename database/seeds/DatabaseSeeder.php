<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(ThemesTableSeeder::class);
        $this->call(ImgsTableSeeder::class);
        $this->call(ElearningSHA::class);
    }
}
