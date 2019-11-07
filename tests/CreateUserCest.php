<?php 

class CreateUserCest
{
    public function createUserViaAPI(\ApiTester $I)
    {
        $accesToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcGkucGlzY2Fkb3JcL2xvZ2luIiwiaWF0IjoxNTczMDE1MDQzLCJleHAiOjE1NzczMzUwNDMsIm5iZiI6MTU3MzAxNTA0MywianRpIjoiRDVKeHFZUEV4ZmZwanhDdyIsInN1YiI6MSwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.zcDqKyQHUt6yBJo2859tyQraRr4sVa161V4VYZTKQp4";
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
