<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Post;
use App\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => env('ADMIN_NAME', 'Admin'),
            'email' => env('ADMIN_EMAIL', 'dejan@sma.il'),
            'password' => Hash::make(env('ADMIN_PASSWORD', '111111')),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        if (! $admin->save()) {
            Log::info('Unable to create admin '.$admin->name, (array)$admin->errors());
        } else {
            Log::info('Created admin "'.$admin->name.'" <'.$admin->email.'>');
        }

        factory(User::class, 9)->create();
        factory(Category::class, 5)->create();
        factory(Post::class, 150)->create();
    }
}
