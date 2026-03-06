<?php

namespace ProvokativeLook\Infrastructure\Repository;

use Bitrix\Crm\Service\Container;
use Bitrix\Crm\ItemIdentifier;

use CCrmOwnerType;

use ProvokativeLook\Infrastructure\Adapter\SmartInvoiceItem;
use ProvokativeLook\Domain\Entity\SmartInvoice;
use ProvokativeLook\Domain\Entity\Deal;

final class SmartInvoiceRepository
{
    private $factory;

    public function __construct()
    {
        $this->factory = Container::getInstance()->getFactory(CCrmOwnerType::SmartInvoice);
    }

    public function getItem(int $id): ?SmartInvoice
    {
        $item = $this->factory->getItem($id);

        if (!$item)
            return null;

        return new SmartInvoice(
            new SmartInvoiceItem($item)
        );
    }

    public function create(array $fields = []): SmartInvoice
    {
        $item = $this->factory->createItem();

        foreach ($fields as $field => $value)
            $item->set($field, $value);

        return new SmartInvoice(new SmartInvoiceItem($item));
    }

    public function createForDeal(Deal $deal, string $title, array $productRows): ?int
    {
        $dealId = (int)$deal->getId();

        $invoice = $this->create();

        $invoice->setTitle($title);
        $invoice->setContactId($deal->getContactId());
        $invoice->setCompanyId($deal->getCompanyId());
        $invoice->setCurrencyId($deal->getCurrencyId());
        $invoice->setAssignedById($deal->getAssignedById());

        $invoice->setStageId('NEW');
        $invoice->setParentId(CCrmOwnerType::Deal, $dealId);
        $invoice->setProductRows($productRows);

        $invoiceId = (int)$this->saveLaunch($invoice);

        if ($invoiceId <= 0) return null;

        Container::getInstance()->getRelationManager()->bindItems(
            new ItemIdentifier(CCrmOwnerType::Deal, $dealId),
            new ItemIdentifier(CCrmOwnerType::SmartInvoice, $invoiceId)
        );

        return $invoiceId;
    }

    public function getStages(int $categoryId = 0): array
    {
        $collection = $this->factory->getStages($categoryId)->getAll();

        return array_reduce($collection, function ($carry, $stage)
        {
            $carry[$stage->getStatusId()] = $stage->getName();
            return $carry;
        }, []);
    }

    public function saveLaunch(SmartInvoice $invoice): int
    {
        $item = $invoice->inner();

        $operation = $item->getId()
            ? $this->factory->getUpdateOperation($item)
            : $this->factory->getAddOperation($item);

        $result = $operation->launch();

        if (!$result->isSuccess())
            throw new \RuntimeException(implode('; ', $result->getErrorMessages()));

        return (int)$item->getId();
    }
}