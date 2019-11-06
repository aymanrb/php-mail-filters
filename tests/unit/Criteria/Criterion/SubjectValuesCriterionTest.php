<?php

namespace MailFilters\Tests\unit\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\Criterion\AttachmentsCriterion;
use MailFilters\Criteria\Criterion\SubjectCriterion;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SubjectValuesCriterionTest extends TestCase
{

    public function testCheckCriterionWithSingleFullMatchedSubject()
    {
        $dummyMessageMock = $this->createMessageAdapterMock('Welcome to Mail Filter Project');

        $subjectValuesCriterion = new SubjectCriterion(['Welcome to Mail Filter Project']);

        $subjectCheckResults = $subjectValuesCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($subjectCheckResults);
        $this->assertTrue($subjectCheckResults);
    }

    public function testCheckCriterionWithSinglePartialMatchedSubject()
    {
        $dummyMessageMock = $this->createMessageAdapterMock('Welcome to Mail Filter Project');

        $subjectValuesCriterion = new SubjectCriterion(['Welcome to *']);

        $subjectCheckResults = $subjectValuesCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($subjectCheckResults);
        $this->assertTrue($subjectCheckResults);
    }

    public function testCheckCriterionWithoutAsterixWillNotDoPartialMatch()
    {
        $dummyMessageMock = $this->createMessageAdapterMock('Welcome to Mail Filter Project');

        $subjectValuesCriterion = new SubjectCriterion(['Welcome to']);

        $subjectCheckResults = $subjectValuesCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($subjectCheckResults);
        $this->assertFalse($subjectCheckResults);
    }

    public function testCheckCriterionWithMultipleValuesMatchedSubject()
    {
        $dummyMessageMock = $this->createMessageAdapterMock('Welcome to Mail Filter Project');

        $subjectValuesCriterion = new SubjectCriterion(['Welcome to *', 'Check for this too ... ']);

        $subjectCheckResults = $subjectValuesCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($subjectCheckResults);
        $this->assertTrue($subjectCheckResults);
    }

    public function testCheckCriterionWithoutUnMatchedSubject()
    {
        $dummyMessageMock = $this->createMessageAdapterMock('Welcome to Mail Filter Project');

        $subjectValuesCriterion = new SubjectCriterion(['Welcome to the', 'Check for this too ... ']);

        $subjectCheckResults = $subjectValuesCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($subjectCheckResults);
        $this->assertFalse($subjectCheckResults);
    }

    protected function createMessageAdapterMock(string $messageSubject): MockObject
    {
        $dummyMessageMock = $this->getMockBuilder(MailMessageAdapterInterface::Class)->getMock();
        $dummyMessageMock
            ->method('getSubject')
            ->will($this->returnValue($messageSubject));

        return $dummyMessageMock;
    }
}
