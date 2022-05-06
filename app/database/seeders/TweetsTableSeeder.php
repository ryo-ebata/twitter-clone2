<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tweet;
use Illuminate\Support\Str;
use App\Models\User;

class TweetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $all_users = $user->get();

        foreach ($all_users as $user) {
            Tweet::create([
                'uuid'       => Str::uuid(),
                'user_id'    => $user->uuid,
                'text'       => 'これはテスト投稿',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}