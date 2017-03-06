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
        factory(App\Category::class, 10)->create();
        factory(App\Book::class, 50)->create();

        App\User::create([
            'name' => 'Cosme Fulanito',
            'email' => 'cosme@gmail.com',
            'password' => bcrypt('1234')
        ]);
    }
}
