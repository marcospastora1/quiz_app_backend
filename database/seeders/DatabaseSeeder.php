<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TipoUserSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AlunoUserSeeder::class);
        $this->call(ProfessorUserSeeder::class);
        $this->call(QuizStatusSeeder::class);
    }
}
