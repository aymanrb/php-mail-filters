<?php

namespace MailFilters\Tests\unit\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\Criterion\FromCriterion;
use MailFilters\Criteria\Criterion\RecipientCriterion;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FromCriterionTest extends TestCase
{
    public function testCheckCriterionWithWithSingleValueSuccess()
    {
        $dummyMessageMock = $this->createMessageAdapterMock('example@test.com');

        $fromCriterion = new FromCriterion(['example@test.com']);
        $fromCriterionResult = $fromCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($fromCriterionResult);
        $this->assertTrue($fromCriterionResult);
    }

    public function testCheckCriterionWithWithMultiValueSuccess()
    {
        $dummyMessageMock = $this->createMessageAdapterMock('example@test.com');

        $fromCriterion = new FromCriterion(['example@test.net','*@test.com']);
        $fromCriterionResult = $fromCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($fromCriterionResult);
        $this->assertTrue($fromCriterionResult);
    }

    public function testCheckCriterionWithWithMultiValueFailed()
    {
        $dummyMessageMock = $this->createMessageAdapterMock('example@test.com');

        $fromCriterion = new FromCriterion(['example@test.net','*@test.org']);
        $fromCriterionResult = $fromCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($fromCriterionResult);
        $this->assertFalse($fromCriterionResult);
    }

    public function testCheckCriterionWithValueNotMatchedInAnyRecipientsList()
    {
        $dummyMessageMock = $this->createMessageAdapterMock(
            'info@example.com',
            ['info@example.net', 'test@example.com'],
            ['hidden@example.com']
        );

        $toCriterion = new RecipientCriterion(['findme@example.com']);
        $toCriterionResult = $toCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($toCriterionResult);
        $this->assertFalse($toCriterionResult);
    }

    protected function createMessageAdapterMock(string $senderAddress): MockObject
    {
        $dummyMessageMock = $this->getMockBuilder(MailMessageAdapterInterface::Class)->getMock();
        $dummyMessageMock
            ->method('getSenderAddress')
            ->will($this->returnValue($senderAddress));

        return $dummyMessageMock;
    }
}
