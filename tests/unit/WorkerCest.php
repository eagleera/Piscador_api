<?php

class WorkerCest
{
    public function canCreateWorker(UnitTester $I)
    {
        $faker = Faker\Factory::create();
        $data = [
            'nombre' => $faker->creditCardType,
            'rol_id' => $faker->randomNumber,
            'ranch_id' => $faker->randomNumber
        ];

        $worker = new App\Http\Models\Worker($data);
        \PHPUnit_Framework_Assert::assertInstanceOf(App\Http\Models\Worker::class, $worker);
        \PHPUnit_Framework_Assert::assertEquals($data['nombre'], $worker->nombre);
        \PHPUnit_Framework_Assert::assertEquals($data['rol_id'], $worker->rol_id);
        \PHPUnit_Framework_Assert::assertEquals($data['ranch_id'], $worker->ranch_id);
    }
}
