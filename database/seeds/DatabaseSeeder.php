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
        $this->call(CSVMenteeSeeder::class);
        $this->call(CSVMentorSeeder::class);
        $this->call(QuestionerSeed::class);
        $this->call(MateriSeed::class);
        $this->call(AgendaSeed::class);

    }
}
