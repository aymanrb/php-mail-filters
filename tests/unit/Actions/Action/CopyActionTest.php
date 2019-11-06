<?php

namespace MailFilters\Tests\unit\Actions\Action;

use MailFilters\Actions\Action\CopyAction;
use MailFilters\Actions\ActionConstantsInterface;
use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Exception\MailActionException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CopyActionTest extends TestCase
{
    private const NEW_DIRECTORY_NAME = 'copy_to_directory';

    public function testConstructionWithoutParametersFails(): void
    {
        $this->expectException(MailActionException::class);
        $this->expectExceptionMessage('Destination directory should not be empty');

        new CopyAction('');

    }

    public function testTriggerActionOnSuccess(): void
    {
        $copyAction = new CopyAction(self::NEW_DIRECTORY_NAME);

        $dummyMessageMock = $this->createMessageAdapterMock(true);

        $copyAction->triggerAction($dummyMessageMock);
        $copyActionResults = $copyAction->getActionReturns();

        $this->assertIsArray($copyActionResults);
        $this->assertArrayHasKey(ActionConstantsInterface::IS_COPIED, $copyActionResults);
        $this->assertTrue(
            $copyActionResults[ActionConstantsInterface::IS_COPIED]
        );
    }

    public function testTriggerActionFailure(): void
    {
        $copyAction = new CopyAction(self::NEW_DIRECTORY_NAME);

        $dummyMessageMock = $this->createMessageAdapterMock(false);

        $copyAction->triggerAction($dummyMessageMock);
        $copyActionResults = $copyAction->getActionReturns();

        $this->assertIsArray($copyActionResults);
        $this->assertArrayHasKey(ActionConstantsInterface::IS_COPIED, $copyActionResults);
        $this->assertFalse(
            $copyActionResults[ActionConstantsInterface::IS_COPIED]
        );
    }

    protected function createMessageAdapterMock(bool $isCopyActionSuccessful = true): MockObject
    {
        $dummyMessageMock = $this->getMockBuilder(MailMessageAdapterInterface::Class)->getMock();
        $dummyMessageMock
            ->expects($this->once())
            ->method('copyTo')
            ->will($this->returnValue($isCopyActionSuccessful));

        return $dummyMessageMock;
    }
}
