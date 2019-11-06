<?php

namespace MailFilters\Tests\unit\Actions\Action;

use MailFilters\Actions\Action\ReturnValuesAction;
use MailFilters\Actions\ActionConstantsInterface;
use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Exception\MailActionException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ReturnValuesActionTest extends TestCase
{
    public function testConstructionWithoutParametersFails()
    {
        $this->expectException(MailActionException::class);
        $this->expectExceptionMessage('Return action parameters are empty!');

        new ReturnValuesAction([]);

    }

    public function testTriggerActionOnSuccess()
    {
        $returnArray = [
            'return' => 'a value here',
            'is this the messages we are looking for' => true,
        ];

        $moveMailAction = new ReturnValuesAction($returnArray);

        $dummyMessageMock = $this->createMessageAdapterMock(true);

        $moveMailAction->triggerAction($dummyMessageMock);
        $returnActionResults = $moveMailAction->getActionReturns();

        $this->assertIsArray($returnActionResults);
        $this->assertArrayHasKey(ActionConstantsInterface::USER_SPECIFIC_PARAMETERS, $returnActionResults);
        $this->assertEquals($returnArray, $returnActionResults[ActionConstantsInterface::USER_SPECIFIC_PARAMETERS]);
    }

    protected function createMessageAdapterMock(): MockObject
    {
        $dummyMessageMock = $this->getMockBuilder(MailMessageAdapterInterface::Class)->getMock();

        return $dummyMessageMock;
    }
}
