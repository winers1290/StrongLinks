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
        factory(App\User::class, 50)->create()->each(function($u){
           
            $u->Profile()->save(factory(App\Profile::class)->make());
            
            for($i = 0; $i < 10; $i++)
            {
                $u->Posts()->save(factory(App\Post::class)->make());
            }
            
            $u->CBTs()->save(factory(App\CBT::class)->make());
            
            
        });
        
        factory(App\Name::class, 1000)->create();
        factory(App\PostComment::class, 1000)->create();
        factory(App\PostCommentReply::class, 500)->create();
        factory(App\PostEmotion::class, 500)->create();
        factory(App\PostReaction::class, 500)->create();
        
        $emotions = [
            'Anger',
            'Love',
            'Hate',
            'Limerence',
            'Happy',
            'Sad',
        ];
        
        foreach($emotions as $emotion)
        {
            DB::table('emotions')->insert([
                'emotion'         =>  $emotion,
                'description'   => 'test',
            ]);
        }

        
    }
}
