<?php 

class CreateUserCest
{
    public function createUserViaAPI(\ApiTester $I)
    {
        $I->amConnectedToDatabase ('test');
        $accesToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGkucGlzY2Fkb3JcL2xvZ2luIiwiaWF0IjoxNTczNDMxODA2LCJleHAiOjE1Nzc3NTE4MDYsIm5iZiI6MTU3MzQzMTgwNiwianRpIjoiWFpVQ2RlcWR0UEpZR05reiIsInN1YiI6MSwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.19cd-Zk8gElgrD7zuaVao-Ut4zj-SegVFOmDTQaEO1A";
        $I->amBearerAuthenticated($accesToken);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/register', [
            'name' => 'davert',
            'email' => 'davert@codeception.com',
            'password' => '1234',
            'password_confirmation' => '1234'
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED); // 201
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['message' => 'CREATED']);
    }
    // public function _before(ApiTester $I)
    // {
        
    // }

    // // tests
    // public function tryToTest(ApiTester $I)
    // {
    // }
}
