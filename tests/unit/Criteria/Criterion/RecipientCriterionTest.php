<?php

namespace MailFilters\Tests\unit\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\Criterion\RecipientCriterion;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RecipientCriterionTest extends TestCase
{
    public function testCheckCriterionWithWithValueInToRecipientsList()
    {
        $dummyMessageMock = $this->createMessageAdapterMock('info@example.com', ['info@example.org'], []);

        $recipientCriterion = new RecipientCriterion(['info@example.org']);
        $recipientCriterionResult = $recipientCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($recipientCriterionResult);
        $this->assertTrue($recipientCriterionResult);
    }

    public function testCheckCriterionWithValueMatchedInCcRecipientsList()
    {
        $dummyMessageMock = $this->createMessageAdapterMock(
            'info@example.com',
            ['info@example.net', 'test@example.com'],
            ['hidden@example.com']
        );

        $toCriterion = new RecipientCriterion(['info@example.net']);
        $toCriterionResult = $toCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($toCriterionResult);
        $this->assertTrue($toCriterionResult);
    }

    public function testCheckCriterionWithValueMatchedInBccRecipientsList()
    {
        $dummyMessageMock = $this->createMessageAdapterMock(
            'info@example.com',
            ['info@example.net', 'test@example.com'],
            ['hidden@example.com']
        );

        $toCriterion = new RecipientCriterion(['hidden@example.com', '*@example.org']);
        $toCriterionResult = $toCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($toCriterionResult);
        $this->assertTrue($toCriterionResult);
    }

    public function testCheckCriterionWithValuePartiallyMatchedInRecipientsList()
    {
        $dummyMessageMock = $this->createMessageAdapterMock(
            'info@example.com',
            ['info@example.net', 'test@example.com'],
            ['hidden@example.com']
        );

        $toCriterion = new RecipientCriterion(['*@example.net']);
        $toCriterionResult = $toCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($toCriterionResult);
        $this->assertTrue($toCriterionResult);
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

    protected function createMessageAdapterMock(
        string $recipient,
        array $ccRecipients,
        array $bccRecipients
    ): MockObject {
        $dummyMessageMock = $this->getMockBuilder(MailMessageAdapterInterface::Class)->getMock();
        $dummyMessageMock
            ->method('getToAddresses')
            ->will($this->returnValue([$recipient]));
        $dummyMessageMock
            ->method('getCcAddresses')
            ->will($this->returnValue($ccRecipients));
        $dummyMessageMock
            ->method('getBccAddresses')
            ->will($this->returnValue($bccRecipients));

        return $dummyMessageMock;
    }
}
