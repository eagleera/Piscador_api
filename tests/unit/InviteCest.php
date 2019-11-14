<?php

class InviteCest
{
    public function canCreateInvite(UnitTester $I)
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\Lorem($faker));
        $data = [
            'ranch_id' => $faker->randomNumber,
            'codigo' => $faker->randomNumber,
            'taken' => $faker->boolean,
        ];

        $invite = new App\Http\Models\Invite($data);
        \PHPUnit_Framework_Assert::assertInstanceOf(App\Http\Models\Invite::class, $invite);
        \PHPUnit_Framework_Assert::assertEquals($data['ranch_id'], $invite->ranch_id);
        \PHPUnit_Framework_Assert::assertEquals($data['codigo'], $invite->codigo);
        \PHPUnit_Framework_Assert::assertEquals($data['taken'], $invite->taken);
    }
}
