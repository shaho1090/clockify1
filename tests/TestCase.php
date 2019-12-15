<?php

namespace Tests;

use App\User;
use App\WorkSpace;
use Faker\Factory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

   // public $inputString = null;
   // protected $user;

    //protected $workSpace;

   /* public function setUp():void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
    }*/

    public function login()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        return $user;
    }
    /*
     * @test
     * */

    public function registerUserAndCreateWorkSpace()
    {
        $users = factory(User::class, 20)
            ->create()
            ->each(function ($user) {
                $user->workSpaces()->save(factory(WorkSpace::class)->create([
                    'title' => $user->name.'work space',
                ]));
            });

        $user = $users[rand(1, 20)];

        $this->actingAs($user);

        return $user;
    }

//    public function createManyProjects()
//    {
//        $faker = new Faker();
//
//        $user = $this->registerUserAndCreateWorkSpace();
//
//        $userWorkSpaceId = $user->workSpaces()->get()->first()->pivot->id;
//
//        $user->workSpaces()->find($userWorkSpaceId)->projects()->createMany([
//            ['title'=> 'test project A',],
//            ['title'=> 'test project B',],
//            ['title'=> 'test project C',],
//            ['title'=> 'test project D',],
//        ]);
//    }



    /*  public function assertStringLengthBetween(int $from ,int $to)
      {
          if ($from<=$this->inputString && $this->inputString<=$to){
              return true;
          }

          return false;
      }*/

   /* public function injectStringLengthBetween(int $from = 0, int $to = 255)
    {
        if (0<= $from && $to <=255) {
            for ($counter = $from; $counter <= $to; $counter++) {
                return Str::random($counter);
            }
        }

        return 'during length mismatch!';
    }*/
}
