<?php

namespace ProvokativeLook\Domain\Field;

use ProvokativeLook\Domain\Entity\Contracts\CrmItemInterface;
use ProvokativeLook\Infrastructure\Field\FieldResolver;
class LeadFields implements CrmItemInterface
{
    private FieldResolver $resolver;

    public function __construct(
        private CrmItemInterface $item
    ) {
        $this->resolver = new FieldResolver();
    }

    public function __call(string $method, array $args)
    {
        if (str_starts_with($method, 'get'))
        {
            $field = strtoupper(preg_replace('/(?<!^)[A-Z]/', '_$0', substr($method, 3)));
            return $this->get($field);
        }

        if (str_starts_with($method, 'set'))
        {
            $field = strtoupper(preg_replace('/(?<!^)[A-Z]/', '_$0', substr($method, 3)));
            return $this->set($field, $args[0] ?? null);
        }

        if (method_exists($this->item, $method))
            return $this->item->$method(...$args);

        throw new \BadMethodCallException("Method {$method} does not exist");
    }

    public function get(string $key): mixed
    {
        $field = $this->resolver->resolve($key) ?? $key;

        return $this->item->get($field);
    }

    public function set(string $key, mixed $value): void
    {
        $field = $this->resolver->resolve($key) ?? $key;

        $this->item->set($field, $value);
    }
}