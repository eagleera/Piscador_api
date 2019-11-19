<?php 

class CreateUserApiCest
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
        $this->token = $data['token'];
    }

    public function createUser(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/register', [
            'name' => 'davert',
            'email' => 'daguilera3221@gmail.com',
            'password' => '1234',
            'password_confirmation' => '1234'
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED); // 201
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['msg' => 'CREATED']);
    }

    public function loginUser(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/login', [
            'email' => 'daguilera3220@gmail.com',
            'password' => '1234'
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['email' => 'daguilera3220@gmail.com']);
    }

    public function currentUser(\ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/me');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['user' => [
            'name' => "davert",
            'email' => "daguilera3220@gmail.com"
        ],
        'msg' => 'success'
        ]);
    }

    public function logoutUser(\ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/logout');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['msg' => 'logged out']);
    }
}
