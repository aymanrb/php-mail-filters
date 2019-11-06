<?php

namespace MailFilters\Tests\unit\Actions\Action;

use MailFilters\Actions\Action\DeleteAction;
use MailFilters\Actions\ActionConstantsInterface;
use MailFilters\Adapters\MailMessageAdapterInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteActionTest extends TestCase
{
    public function testTriggerActionOnSuccess(): void
    {
        $deleteAction = new DeleteAction();

        $dummyMessageMock = $this->createMessageAdapterMock(true);

        $deleteAction->triggerAction($dummyMessageMock);
        $deleteActionResults = $deleteAction->getActionReturns();

        $this->assertIsArray($deleteActionResults);
        $this->assertArrayHasKey(ActionConstantsInterface::IS_DELETED, $deleteActionResults);
        $this->assertTrue(
            $deleteActionResults[ActionConstantsInterface::IS_DELETED]
        );
    }

    public function testTriggerActionOnFailure(): void
    {
        $deleteAction = new DeleteAction();

        $dummyMessageMock = $this->createMessageAdapterMock(false);

        $deleteAction->triggerAction($dummyMessageMock);
        $deleteActionResults = $deleteAction->getActionReturns();

        $this->assertIsArray($deleteActionResults);
        $this->assertArrayHasKey(ActionConstantsInterface::IS_DELETED, $deleteActionResults);
        $this->assertFalse(
            $deleteActionResults[ActionConstantsInterface::IS_DELETED]
        );
    }

    protected function createMessageAdapterMock(bool $isDeleteActionSuccessful = true): MockObject
    {
        $dummyMessageMock = $this->getMockBuilder(MailMessageAdapterInterface::Class)->getMock();
        $dummyMessageMock
            ->expects($this->once())
            ->method('delete')
            ->will($this->returnValue($isDeleteActionSuccessful));

        return $dummyMessageMock;
    }
}
