<?php

namespace MailFilters\Tests\unit\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\Criterion\ToCriterion;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ToCriterionTest extends TestCase
{
    public function testCheckCriterionWithSingleFullMatchedRecipient()
    {
        $dummyMessageMock = $this->createMessageAdapterMock('info@example.com');

        $toCriterion = new ToCriterion(['info@example.com']);
        $toCriterionResult = $toCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($toCriterionResult);
        $this->assertTrue($toCriterionResult);
    }

    public function testCheckCriterionWithMultiPartialMatchedRecipient()
    {
        $dummyMessageMock = $this->createMessageAdapterMock('info@example.com');

        $toCriterion = new ToCriterion(['*@example.com', '*@example.org']);
        $toCriterionResult = $toCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($toCriterionResult);
        $this->assertTrue($toCriterionResult);
    }

    public function testCheckCriterionWithoutMatchedRecipient()
    {
        $dummyMessageMock = $this->createMessageAdapterMock('info@example.net');

        $toCriterion = new ToCriterion(['*@example.com', '*@example.org']);
        $toCriterionResult = $toCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($toCriterionResult);
        $this->assertFalse($toCriterionResult);
    }

    protected function createMessageAdapterMock(string $recipient): MockObject
    {
        $dummyMessageMock = $this->getMockBuilder(MailMessageAdapterInterface::Class)->getMock();
        $dummyMessageMock
            ->method('getToAddresses')
            ->will($this->returnValue([$recipient]));

        return $dummyMessageMock;
    }
}
