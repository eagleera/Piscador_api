<?php 

class CreateUserCest
{
    public function createUser(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/register', [
            'name' => 'davert',
            'email' => 'daguilera3220@gmail.com',
            'password' => '1234',
            'password_confirmation' => '1234'
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED); // 201
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['message' => 'CREATED']);
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
        $accesToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGkucGlzY2Fkb3JcL2xvZ2luIiwiaWF0IjoxNTczNDQwODQ4LCJleHAiOjE1Nzc3NjA4NDgsIm5iZiI6MTU3MzQ0MDg0OCwianRpIjoiQ1kzcjhvSmVwQkYwdFVveSIsInN1YiI6MywicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.T_VlJRm-nkhUB4Y86fMomgBNHilQBYBUBxXmcioxoP0";
        $I->amBearerAuthenticated($accesToken);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/me');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['email' => 'daguilera3220@gmail.com']);
    }
}
