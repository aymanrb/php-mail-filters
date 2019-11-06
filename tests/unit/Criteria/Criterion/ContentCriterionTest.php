<?php

namespace MailFilters\Tests\unit\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\Criterion\ContentCriterion;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ContentCriterionTest extends TestCase
{
    public function testCheckCriterionWithSingleMatchForContent()
    {
        $dummyMessageMock = $this->createMessageAdapterMock('Text HTML <b>Content</b>', 'Text Content');

        $contentCriterion = new ContentCriterion('* Content');
        $contentCheckResults = $contentCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($contentCheckResults);
        $this->assertTrue($contentCheckResults);
    }

    public function testCheckCriterionWithMultiMatchForContent()
    {
        $dummyMessageMock = $this->createMessageAdapterMock('Text HTML <b>Content</b>', 'Text Content');

        $contentCriterion = new ContentCriterion(['Test Phrase', '* Content', 'A string: *']);
        $contentCheckResults = $contentCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($contentCheckResults);
        $this->assertTrue($contentCheckResults);
    }

    public function testCheckCriterionWithMultiMatchForContentWithHtmlOnly()
    {
        $dummyMessageMock = $this->createMessageAdapterMock('Text HTML <b>Content</b>', '');

        $contentCriterion = new ContentCriterion(['Test Phrase', '* Content*', 'A string: *']);
        $contentCheckResults = $contentCriterion->checkCriterion($dummyMessageMock);

        $this->assertIsBool($contentCheckResults);
        $this->assertTrue($contentCheckResults);
    }

    protected function createMessageAdapterMock(string $htmlText, string $plainText): MockObject
    {
        $dummyMessageMock = $this->getMockBuilder(MailMessageAdapterInterface::Class)->getMock();
        $dummyMessageMock
            ->method('getBodyHtml')
            ->will($this->returnValue($htmlText));

        $dummyMessageMock
            ->method('getBodyText')
        ->will($this->returnValue($plainText));

        return $dummyMessageMock;
    }
}
