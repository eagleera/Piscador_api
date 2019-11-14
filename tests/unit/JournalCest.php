<?php

class JournalCest
{
    public function canCreateJournal(UnitTester $I)
    {
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\Lorem($faker));
        $data = [
            'ranch_id' => $faker->randomNumber,
            'user_id' => $faker->randomNumber,
            'amount' => $faker->randomNumber,
            'notes' => $faker->text
        ];

        $journal = new App\Http\Models\Journal($data);
        \PHPUnit_Framework_Assert::assertInstanceOf(App\Http\Models\Journal::class, $journal);
        \PHPUnit_Framework_Assert::assertEquals($data['user_id'], $journal->user_id);
        \PHPUnit_Framework_Assert::assertEquals($data['ranch_id'], $journal->ranch_id);
        \PHPUnit_Framework_Assert::assertEquals($data['amount'], $journal->amount);
        \PHPUnit_Framework_Assert::assertEquals($data['notes'], $journal->notes);
    }
}
