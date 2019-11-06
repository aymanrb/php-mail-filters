<?php

namespace MailFilters\Tests\unit\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\Criterion\AttachmentsCriterion;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AttachmentsCriterionTest extends TestCase
{

    public function testCheckCriterionWithAttachments()
    {
        $dummyMessageMock = $this->createMessageAdapterMock(true);

        $hasAttachmentCriterion = new AttachmentsCriterion();

        $hasAttachmentCheckResults = $hasAttachmentCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($hasAttachmentCheckResults);
        $this->assertTrue($hasAttachmentCheckResults);
    }

    public function testCheckCriterionWithoutAttachments()
    {
        $dummyMessageMock = $this->createMessageAdapterMock(false);

        $hasAttachmentCriterion = new AttachmentsCriterion();

        $hasAttachmentCheckResults = $hasAttachmentCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($hasAttachmentCheckResults);
        $this->assertFalse($hasAttachmentCheckResults);
    }

    protected function createMessageAdapterMock(bool $hasAttachments): MockObject
    {
        $dummyMessageMock = $this->getMockBuilder(MailMessageAdapterInterface::Class)->getMock();
        $dummyMessageMock
            ->expects($this->once())
            ->method('hasAttachments')
            ->will($this->returnValue($hasAttachments));

        return $dummyMessageMock;
    }
}
