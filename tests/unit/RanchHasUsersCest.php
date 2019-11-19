<?php

class RanchHasUsersUnitCest
{
    public function canCreateRanchHasUser(UnitTester $I)
    {
        $faker = Faker\Factory::create();
        $data = [
            'ranch_id' => $faker->randomNumber,
            'user_id' => $faker->randomNumber
        ];

        $ranchUser = new App\Http\Models\RanchHasUsers($data);
        \PHPUnit_Framework_Assert::assertInstanceOf(App\Http\Models\RanchHasUsers::class, $ranchUser);
        \PHPUnit_Framework_Assert::assertEquals($data['user_id'], $ranchUser->user_id);
        \PHPUnit_Framework_Assert::assertEquals($data['user_id'], $ranchUser->user_id);
    }
}
