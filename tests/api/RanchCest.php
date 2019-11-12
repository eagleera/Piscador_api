<?php 

class RanchCest
{
    public function _before(\ApiTester $I)
    {
        $I->sendPOST('/login', [
            'email' => 'prueba_email@gg.com',
            'password' => '1234'
        ]);
        $response = $I->grabResponse();
        $data = json_decode($response, true);
        $this->token = $data['token'];
    }

    public function createRanch(\ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/ranch', [
            'name' => 'La quinta yirinuqui',
            'address' => 'en la quinta avenida',
            'size' => 13,
            'firsttime' => true
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'msg' => 'created',
            'user' => [
                'default_ranch' => 2,
                'ranch' => [
                    'id' => 2
                ]
            ]
        ]);
    }
}
