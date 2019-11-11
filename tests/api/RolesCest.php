<?php 

class RolesCest
{
    protected $token;

    public function _before(\ApiTester $I)
    {
        $I->sendPOST('/login', [
            'email' => 'daguilera3220@gmail.com',
            'password' => '1234'
        ]);
        $response = $I->grabResponse();
        $data = json_decode($response, true);
        codecept_debug($data['token']);
        $this->token = $data['token'];
    }

    public function getTipos(\ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/tipos');
        $response = $I->grabResponse();
        $data = json_decode($response, true);
        \PHPUnit_Framework_Assert::assertCount(4, $data);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
    }

    public function getRoles(\ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/roles');
        $response = $I->grabResponse();
        $data = json_decode($response, true);
        \PHPUnit_Framework_Assert::assertCount(2, $data);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
        [
            'id' => 1,
            'nombre' => 'Rol prueba 1',
            'tipo_id' => 1
        ],
        [
            'id' => 2,
            'nombre' => 'Rol prueba 2',
            'tipo_id' => 1
        ]
        ]);
    }

    public function createRole(\ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/rol', [
            'nombre' => 'prueba_rol',
            'cantidad' => 1234,
            'tipo_id' => 2
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['msg' => 'created']);
    }

    public function updateRole(\ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPATCH('/rol/1', [
            'nombre' => 'prueba_rol',
            'cantidad' => 1234,
            'tipo_id' => 2
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['msg' => 'updated']);
    }
    public function deleteRole(\ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendDELETE('/rol/2');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['msg' => 'deleted']);
    }
}
