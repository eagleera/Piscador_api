<?php

class RoleUnitCest
{
    public function canCreateRole(UnitTester $I)
    {
        $faker = Faker\Factory::create();
        $data = [
            'nombre' => $faker->name,
            'cantidad' => $faker->randomNumber,
            'tipo_id' => $faker->randomNumber
        ];

        $role = new App\Http\Models\Role($data);
        \PHPUnit_Framework_Assert::assertInstanceOf(App\Http\Models\Role::class, $role);
        \PHPUnit_Framework_Assert::assertEquals($data['nombre'], $role->nombre);
        \PHPUnit_Framework_Assert::assertEquals($data['cantidad'], $role->cantidad);
        \PHPUnit_Framework_Assert::assertEquals($data['tipo_id'], $role->tipo_id);
    }
}
