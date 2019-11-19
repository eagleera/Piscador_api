<?php

class RanchUnitCest
{
    public function canCreateRanch(UnitTester $I)
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\en_US\Address($faker));
        $data = [
            'name' => $faker->name,
            'address' => $faker->streetAddress,
            'size' => $faker->randomNumber
        ];

        $ranch = new App\Http\Models\Ranch($data);
        \PHPUnit_Framework_Assert::assertInstanceOf(App\Http\Models\Ranch::class, $ranch);
        \PHPUnit_Framework_Assert::assertEquals($data['name'], $ranch->name);
        \PHPUnit_Framework_Assert::assertEquals($data['address'], $ranch->address);
        \PHPUnit_Framework_Assert::assertEquals($data['size'], $ranch->size);
    }
}
