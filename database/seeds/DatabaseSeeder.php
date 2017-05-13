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
        factory(App\ObjectComment::class, 1000)->create();
        factory(App\PostEmotion::class, 1000)->create();
        factory(App\ObjectReaction::class, 500)->create();
        factory(App\CBTEvidence::class, 500)->create();
        factory(App\CBTAutomaticThought::class, 500)->create();
        factory(App\CBTRationalThought::class, 500)->create();
        factory(App\CBTEmotion::class, 500)->create();

        $emotions = [
            'Anger',
            'Love',
            'Hate',
            'Happy',
            'Sad',
        ];

        foreach($emotions as $emotion)
        {
            DB::table('emotions')->insert([
                'emotion'         =>  $emotion,
                'active'         =>  $emotion,
                'description'   => 'test',
            ]);
        }

        $objectTypes = [
          'post',
          'cbt'
        ];

        foreach($objectTypes as $type)
        {
          DB::table('object_types')->insert([
              'type' => $type,
          ]);
        }


    }
}
