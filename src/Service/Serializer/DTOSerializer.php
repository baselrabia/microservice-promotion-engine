<?php

namespace App\Service\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


class DTOSerializer implements SerializerInterface
{
    private SerializerInterface $serializer;

    public function __construct()
    {
        // public function Serializer::__construct(array $normalizers = [], array $encoders = []) Serializer
        $this->serializer = new Serializer(
            // normalizer
        [new ObjectNormalizer(nameConverter: new CamelCaseToSnakeCaseNameConverter())],

            //encoders
        [new JsonEncoder()]

        );
    }

    public function serialize(mixed $data, string $format, array $context = []): string
    {
         return $this->serializer->serialize($data, $format, $context);
    }

    public function deserialize(mixed $data, string $type, string $format, array $context = []): mixed
    {
        return $this->serializer->deserialize($data, $type, $format, $context);
    }
}