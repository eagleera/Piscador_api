<?php 

class AttendanceApiCest
{
    public function _before(ApiTester $I)
    {
        $I->sendPOST('/login', [
            'email' => 'daguilera3220@gmail.com',
            'password' => '1234'
        ]);
        $response = $I->grabResponse();
        $data = json_decode($response, true);
        $this->token = $data['token'];
    }

    public function addAttendance(ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/attendance', [
            'date' => '2019-11-13',
            'workers' => array([
                'id' => 1,
                'attendance' => true
            ])
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['msg' => 'registered']);
    }

    public function getDayAttendance(ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/attendance/2019-11-12');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([0 =>[
            'attendance_day' => '2019-11-12',
            'ranch_id' => 1,
            'status' => false
        ]]);
    }
    
    public function getRangeAttendance(ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/attendance/payday',[
        'init_date' => '10/11/2019',
        'end_date' => '12/11/2019'
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $response = $I->grabResponse();
        $data = json_decode($response, true);
        \PHPUnit_Framework_Assert::assertCount(3, $data);
        $I->seeResponseContainsJson([0 =>[
            'attendance_day' => '2019-11-10',
            'ranch_id' => 1,
            'status' => "1"
        ]]);
    }
}
