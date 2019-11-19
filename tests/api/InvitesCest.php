<?php 

class InvitesApiCest
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

    public function createInvite(\ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/ranch/create-invite', [
            'codigo' => '1234567'
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['msg' => 'created']);
    }

    public function acceptInvite(\ApiTester $I)
    {
        $I->amBearerAuthenticated($this->token);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/ranch/add-invite', [
            'codigo' => '123456'
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['msg' => 'added']);
    }
}
