<?php

class UserUnitCest
{
    public function canCreateUser(UnitTester $I)
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\Internet($faker));
        $data = [
            'name' => $faker->name,
            'email' => $faker->email
        ];

        $user = new App\User($data);
        \PHPUnit_Framework_Assert::assertInstanceOf(App\User::class, $user);
        \PHPUnit_Framework_Assert::assertEquals($data['name'], $user->name);
        \PHPUnit_Framework_Assert::assertEquals($data['email'], $user->email);
    }
}
