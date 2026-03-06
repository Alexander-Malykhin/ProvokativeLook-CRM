<?php

namespace Domain\Entity;
use PHPUnit\Framework\TestCase;

use ProvokativeLook\Domain\Entity\Contracts\CrmItemInterface;

use ProvokativeLook\Domain\Entity\SmartInvoice;

class SmartInvoiceTest extends TestCase
{
    public function testGetTitle()
    {
        $item = $this->createMock(CrmItemInterface::class);

        $item->method('get')
            ->with('TITLE')
            ->willReturn('Test Invoice');

        $deal = new SmartInvoice($item);

        $this->assertEquals('Test Invoice', $deal->getTitle());
    }

    public function testSetTitle()
    {
        $item = $this->createMock(CrmItemInterface::class);

        $item->expects($this->once())
            ->method('set')
            ->with('TITLE', 'New Invoice');

        $deal = new SmartInvoice($item);

        $deal->setTitle('New Invoice');
    }
}

