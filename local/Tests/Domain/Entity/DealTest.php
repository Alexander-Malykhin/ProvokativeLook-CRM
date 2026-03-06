<?php

namespace Domain\Entity;

use PHPUnit\Framework\TestCase;
use ProvokativeLook\Domain\Entity\Contracts\CrmItemInterface;
use ProvokativeLook\Domain\Entity\Deal;

final class DealTest extends TestCase
{
    public function testGetTitle(): void
    {
        $item = $this->createMock(CrmItemInterface::class);

        $item->method('get')
            ->with('TITLE')
            ->willReturn('Test Deal');

        $deal = new Deal($item);

        $this->assertEquals('Test Deal', $deal->getTitle());
    }

    public function testSetTitle(): void
    {
        $item = $this->createMock(CrmItemInterface::class);

        $item->expects($this->once())
            ->method('set')
            ->with('TITLE', 'New Title');

        $deal = new Deal($item);

        $deal->setTitle('New Title');
    }

    public function testInnerReturnsUnderlyingObject(): void
    {
        $inner = new \stdClass();

        $item = $this->createMock(CrmItemInterface::class);
        $item->method('inner')->willReturn($inner);

        $deal = new Deal($item);

        $this->assertSame($inner, $deal->inner());
    }

    public function testGetCustomFieldUsesGetMethod(): void
    {
        $item = $this->createMock(CrmItemInterface::class);

        $item->expects($this->once())
            ->method('get')
            ->with('UF_CRM_TEST')
            ->willReturn('123');

        $deal = new Deal($item);

        $this->assertSame('123', $deal->get('UF_CRM_TEST'));
    }

    public function testSetCustomFieldUsesSetMethod(): void
    {
        $item = $this->createMock(CrmItemInterface::class);

        $item->expects($this->once())
            ->method('set')
            ->with('UF_CRM_TEST', 777);

        $deal = new Deal($item);

        $deal->set('UF_CRM_TEST', 777);
    }

    public function testMagicGetStageIdCallsGetWithStageIdKey(): void
    {
        $item = $this->createMock(CrmItemInterface::class);

        $item->expects($this->once())
            ->method('get')
            ->with('STAGE_ID')
            ->willReturn('NEW');

        $deal = new Deal($item);

        $this->assertSame('NEW', $deal->getStageId());
    }

    public function testMagicSetAssignedByIdCallsSetWithAssignedByIdKey(): void
    {
        $item = $this->createMock(CrmItemInterface::class);

        $item->expects($this->once())
            ->method('set')
            ->with('ASSIGNED_BY_ID', 5);

        $deal = new Deal($item);

        $deal->setAssignedById(5);
    }

    public function testMagicSetWithoutArgumentPassesNull(): void
    {
        $item = $this->createMock(CrmItemInterface::class);

        $item->expects($this->once())
            ->method('set')
            ->with('TITLE', null);

        $deal = new Deal($item);

        $deal->setTitle();
    }

    public function testProxiesUnknownMethodToItemWhenMethodExists(): void
    {
        $item = new class implements CrmItemInterface
        {
            public function inner(): object
            {
                return new \stdClass();
            }

            public function get(string $field): mixed
            {
                return null;
            }

            public function set(string $field, mixed $value): void{}

            public function doSomething(string $a, int $b): string
            {
                return "ok:$a:$b";
            }
        };

        $deal = new Deal($item);

        $this->assertSame('ok:a:1', $deal->doSomething('a', 1));
    }

    public function testThrowsBadMethodCallWhenNoSuchMethodAndNoCallMagic(): void
    {
        $item = new class implements CrmItemInterface
        {
            public function inner(): object
            {
                return new \stdClass();
            }

            public function get(string $field): mixed
            {
                return null;
            }

            public function set(string $field, $value): void {}
        };

        $deal = new Deal($item);

        $this->expectException(\BadMethodCallException::class);
        $deal->totallyUnknownMethod();
    }
}