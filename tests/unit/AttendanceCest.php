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
}
