<?php

namespace ProvokativeLook\Infrastructure\Repository;

use Bitrix\Crm\Service\Container;
use CCrmOwnerType;

use ProvokativeLook\Infrastructure\Repository\Contracts\DealRepositoryInterface;

use ProvokativeLook\Infrastructure\Adapter\DealItem;
use ProvokativeLook\Domain\Entity\Deal;
final class DealRepository implements DealRepositoryInterface
{
    private $factory;

    public function __construct()
    {
        $this->factory = Container::getInstance()->getFactory(CCrmOwnerType::Deal);
    }
    public function getItem(int $id): ?Deal
    {
        $item = $this->factory->getItem($id);

        if (!$item)
            return null;

        return new Deal(
            new DealItem($item)
        );
    }
    public function create(array $fields = []): Deal
    {
        $item = $this->factory->createItem();

        $defaultFields = [
            'CATEGORY_ID' => 0,
            'STAGE_ID' => 'NEW',
            'ASSIGNED_BY_ID' => 1,
            'CREATED_BY' => 1,
            'UPDATED_BY' => 1,
        ];

        $fields = array_replace($defaultFields, $fields);

        foreach ($fields as $field => $value)
            $item->set($field, $value);

        return new Deal($item);
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
}