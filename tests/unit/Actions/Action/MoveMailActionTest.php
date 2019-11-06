<?php

namespace MailFilters\Tests\unit\Actions\Action;

use MailFilters\Actions\Action\MoveMailAction;
use MailFilters\Actions\ActionConstantsInterface;
use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Exception\MailActionException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MoveMailActionTest extends TestCase
{
    private const NEW_DIRECTORY_NAME = 'new_directory';

    public function testConstructionWithoutParametersFails(): void
    {
        $this->expectException(MailActionException::class);
        $this->expectExceptionMessage('Destination directory should not be empty');

        new MoveMailAction('');

    }

    public function testTriggerActionOnSuccess(): void
    {
        $moveMailAction = new MoveMailAction(self::NEW_DIRECTORY_NAME);

        $dummyMessageMock = $this->createMessageAdapterMock(true);

        $moveMailAction->triggerAction($dummyMessageMock);
        $moveActionResults = $moveMailAction->getActionReturns();

        $this->assertIsArray($moveActionResults);
        $this->assertArrayHasKey(ActionConstantsInterface::IS_MOVED, $moveActionResults);
        $this->assertTrue(
            $moveActionResults[ActionConstantsInterface::IS_MOVED]
        );
    }

    public function testTriggerActionFailure(): void
    {
        $copyAction = new MoveMailAction(self::NEW_DIRECTORY_NAME);

        $dummyMessageMock = $this->createMessageAdapterMock(false);

        $copyAction->triggerAction($dummyMessageMock);
        $moveActionResults = $copyAction->getActionReturns();

        $this->assertIsArray($moveActionResults);
        $this->assertArrayHasKey(ActionConstantsInterface::IS_MOVED, $moveActionResults);
        $this->assertFalse(
            $moveActionResults[ActionConstantsInterface::IS_MOVED]
        );
    }

    protected function createMessageAdapterMock(bool $isMoveActionSuccessful = true): MockObject
    {
        $dummyMessageMock = $this->getMockBuilder(MailMessageAdapterInterface::Class)->getMock();
        $dummyMessageMock
            ->expects($this->once())
            ->method('moveTo')
            ->will($this->returnValue($isMoveActionSuccessful));

        return $dummyMessageMock;
    }
}
