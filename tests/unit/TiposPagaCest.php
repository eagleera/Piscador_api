<?php

class TiposPagaCest
{
    public function canCreateTiposPaga(UnitTester $I)
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\Payment($faker));
        $data = [
            'nombre' => $faker->creditCardType,
        ];

        $tipoPaga = new App\Http\Models\TiposPaga($data);
        \PHPUnit_Framework_Assert::assertInstanceOf(App\Http\Models\TiposPaga::class, $tipoPaga);
        \PHPUnit_Framework_Assert::assertEquals($data['nombre'], $tipoPaga->nombre);
    }
}
