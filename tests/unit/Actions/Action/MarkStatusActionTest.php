<?php

namespace MailFilters\Tests\unit\Actions\Action;

use MailFilters\Actions\Action\MarkStatusAction;
use MailFilters\Actions\ActionConstantsInterface;
use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Exception\MailActionException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MarkStatusActionTest extends TestCase
{
    public function testTriggerActionThrowsExceptionForUnknownStatus(): void
    {
        $this->expectException(MailActionException::class);

        $markStatusAction = new MarkStatusAction('unknown_status');

        $dummyMessageMock = $this->createMessageAdapterMock('markAsRead');
        $markStatusAction->triggerAction($dummyMessageMock);

        $this->expectExceptionMessage('Unknown target status: unknown_status');
    }

    public function testTriggerActionSetReadSuccess(): void
    {
        $markStatusAction = new MarkStatusAction('read');

        $dummyMessageMock = $this->createMessageAdapterMock('markAsRead');

        $markStatusAction->triggerAction($dummyMessageMock);
        $markStatusActionResults = $markStatusAction->getActionReturns();

        $this->assertIsArray($markStatusActionResults);
        $this->assertArrayHasKey(ActionConstantsInterface::STATUS_CHANGED, $markStatusActionResults);
        $this->assertEquals(
            $markStatusActionResults[ActionConstantsInterface::STATUS_CHANGED],
            'Read'
        );
    }

    public function testTriggerActionSetUnreadSuccess(): void
    {
        $markStatusAction = new MarkStatusAction('unread');

        $dummyMessageMock = $this->createMessageAdapterMock('markAsUnread');

        $markStatusAction->triggerAction($dummyMessageMock);
        $markStatusActionResults = $markStatusAction->getActionReturns();

        $this->assertIsArray($markStatusActionResults);
        $this->assertArrayHasKey(ActionConstantsInterface::STATUS_CHANGED, $markStatusActionResults);
        $this->assertEquals(
            $markStatusActionResults[ActionConstantsInterface::STATUS_CHANGED],
            'Unread'
        );
    }

    public function testTriggerActionSetImportantSuccess(): void
    {
        $markStatusAction = new MarkStatusAction('important');

        $dummyMessageMock = $this->createMessageAdapterMock('markMessageAsImportant');

        $markStatusAction->triggerAction($dummyMessageMock);
        $markStatusActionResults = $markStatusAction->getActionReturns();

        $this->assertIsArray($markStatusActionResults);
        $this->assertArrayHasKey(ActionConstantsInterface::STATUS_CHANGED, $markStatusActionResults);
        $this->assertEquals(
            $markStatusActionResults[ActionConstantsInterface::STATUS_CHANGED],
            'Important'
        );
    }

    //TODO: Take into consideration status setting failure and reflect it in tests

    protected function createMessageAdapterMock(string $actionName): MockObject
    {
        $dummyMessageMock = $this->getMockBuilder(MailMessageAdapterInterface::Class)->getMock();
        $dummyMessageMock
            ->method($actionName)
            ->will($this->returnValue(true)); //TODO: Change Action class to take success response into consideration

        return $dummyMessageMock;
    }
}
