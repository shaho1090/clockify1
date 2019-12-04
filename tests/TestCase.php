<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

   // public $inputString = null;
    protected $user;

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
