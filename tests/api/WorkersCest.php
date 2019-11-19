<?php 

class WorkersApiCest
{
    public function _before(\ApiTester $I)
    {
        $I->sendPOST('/login', [
            'email' => 'daguilera3220@gmail.com',
            'password' => '1234'
        ]);
        $response = $I->grabResponse();
        $data = json_decode($response, true);
        $this->token = $data['token'];
    }

    public function getWorkers(\ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/workers');
        $response = $I->grabResponse();
        $data = json_decode($response, true);
        \PHPUnit_Framework_Assert::assertCount(1, $data);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
    }

    public function createWorkers(\ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/worker', [
            'nombre' => 'prueba_worker',
            'rol_id' => 2
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['msg' => 'created', 'worker' => [
            'nombre' => 'prueba_worker',
            'rol_id' => 2,
            'ranch_id' => 1
        ]]);
    }

    public function updateWorker(\ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPATCH('/worker/1', [
            'nombre' => 'prueba_worker',
            'rol_id' => 2
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['msg' => 'updated']);
    }

    public function deleteWorker(\ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendDELETE('/worker/1');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['msg' => 'deleted']);
    }
}
