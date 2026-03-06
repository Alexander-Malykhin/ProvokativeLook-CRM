<?php

namespace Domain\Entity;
use PHPUnit\Framework\TestCase;

use ProvokativeLook\Domain\Entity\Contracts\CrmItemInterface;

use ProvokativeLook\Domain\Entity\Lead;

class LeadTest extends TestCase
{
    public function testGetTitle()
    {
        $item = $this->createMock(CrmItemInterface::class);

        $item->method('get')
            ->with('TITLE')
            ->willReturn('Test Lead');

        $deal = new Lead($item);

        $this->assertEquals('Test Lead', $deal->getTitle());
    }

    public function testSetTitle()
    {
        $item = $this->createMock(CrmItemInterface::class);

        $item->expects($this->once())
            ->method('set')
            ->with('TITLE', 'New Title');

        $deal = new Lead($item);

        $deal->setTitle('New Title');
    }
}

