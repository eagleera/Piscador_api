<?php

class AttendanceUnitCest
{
    public function canCreateAttendance(UnitTester $I)
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\Lorem($faker));
        $data = [
            'worker_id' => $faker->randomNumber,
            'attendance_day' => $faker->randomNumber,
            'status' => $faker->randomNumber,
        ];

        $att = new App\Http\Models\Attendance($data);
        \PHPUnit_Framework_Assert::assertInstanceOf(App\Http\Models\Attendance::class, $att);
        \PHPUnit_Framework_Assert::assertEquals($data['worker_id'], $att->worker_id);
        \PHPUnit_Framework_Assert::assertEquals($data['attendance_day'], $att->attendance_day);
        \PHPUnit_Framework_Assert::assertEquals($data['status'], $att->status);
    }

    public function transformDate(UnitTester $I)
    {
        $controller = new App\Http\Controllers\AttendanceController();
        $result = $controller->transformDate('11/11/2019');
        \PHPUnit_Framework_Assert::assertEquals($result, '2019-11-11');
    }

    public function calculateCambio(UnitTester $I)
    {
        $controller = new App\Http\Controllers\AttendanceController();
        $attendance = [
            ["total" => 150],
            ["total" => 405],
        ];
        $result = $controller->calculateCambio($attendance);
        \PHPUnit_Framework_Assert::assertCount(2, $result);
        \PHPUnit_Framework_Assert::assertCount(7, $result[0][0]["cambio"]);
        \PHPUnit_Framework_Assert::assertCount(7, $result[0][1]["cambio"]);
        \PHPUnit_Framework_Assert::assertEquals($result[0][0]["cambio"], [0,0,1,1,0,0,0]);
        \PHPUnit_Framework_Assert::assertEquals($result[0][1]["cambio"], [0,2,0,0,0,0,1]);
        \PHPUnit_Framework_Assert::assertEquals($result[1], [0,2,1,1,0,0,1]);
    }

    public function calculateTotal(UnitTester $I)
    {
        $data = [0, 2, 2, 1, 0, 1, 0];
        $controller = new App\Http\Controllers\AttendanceController();
        $result = $controller->calculateTotal($data);
        \PHPUnit_Framework_Assert::assertEquals($result, 660);
    }

    public function calculateBills(UnitTester $I)
    {
        $data = 385;
        $controller = new App\Http\Controllers\AttendanceController();
        $result = $controller->calculateBills($data);
        \PHPUnit_Framework_Assert::assertCount(7, $result);
        \PHPUnit_Framework_Assert::assertEquals($result, [0,1,1,1,1,1,1]);
    }

    public function sumarArraysUnoSolo(UnitTester $I)
    {
        $data = [
            [0, 1, 1, 1, 0, 1, 0],
            [0, 1, 1, 0, 0, 0, 0]
        ];
        $controller = new App\Http\Controllers\AttendanceController();
        $result = $controller->sumarArraysUnoSolo($data);
        \PHPUnit_Framework_Assert::assertCount(7, $result);
        \PHPUnit_Framework_Assert::assertEquals($result, [0,2,2,1,0,1,0]);
    }
}
