<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Usertest extends TestCase
{
  /**
  * A basic test example.
  *
  * @return void
  */


public function setUp(){
  parent::setUp();

}
public function testUrl(){
  $response =$this->call('GET','/login');
  $this->assertEquals(200,$response->status());
}
  public function testaUserRegisters(){
    $this->withoutMiddleware();
    $this->withoutEvents();
    $this->visit('/register')
    ->type('UserTest','name')
    ->type('Useremailtest@gmail.com','email')
    ->type('passtest','password')
    ->type('passtest','password_confirmation')
    ->press('Register')
    ->seePageIs('/home');
  }
  public function testaUserLogsin(){
    $this->visit('/login')
    ->type('Useremailtest@gmail.com','email')
    ->type('passtest','password')
    ->check('remember')
    ->press('Login')
    ->see('Logout');
  }
  /*check a forgotten password*/
  public function testIsuserLoged(){
    $user = factory(App\User::class)->create([
        'name' => 'Abigail',
       ]);
          $this->actingAs($user)
                ->withSession(['name' => 'Abigail'])
                ->visit('/home')
                ->see($user->name);

  }

   public function testaUserLogsout(){

      $user = factory(App\User::class)->create([
      'name' => 'Abigail',
     ]);
                $this->actingAs($user)
                      ->withSession(['name' => 'Abigail'])
                      ->visit('/home')
                      ->seePageIs('/home')
                      ->click('Logout')
                      ->see('Login');

    }

  public function testaUsersChecksprofile(){
    /*not the right test */
    $user = factory(App\User::class)->create([
    'name' => 'Abigail',
   ]);
      $this->actingAs($user)
            ->withSession(['name' => 'Abigail'])
            ->visit('/')
            ->click('profile')
            ->seePageIs('/profile');
  }


}
