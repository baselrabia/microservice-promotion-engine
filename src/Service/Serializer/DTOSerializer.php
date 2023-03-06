<?php

namespace App\Service\Serializer;

use App\Event\AfterDtoCreatedEvent;
use Doctrine\Common\Annotations\AnnotationReader;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


class DTOSerializer implements SerializerInterface
{
    private SerializerInterface $serializer;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        // public function Serializer::__construct(array $normalizers = [], array $encoders = []) Serializer
        $this->serializer = new Serializer(
        // normalizer
            [new ObjectNormalizer(
                classMetadataFactory: new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader())),
                nameConverter: new CamelCaseToSnakeCaseNameConverter()
            )],

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
        $dto = $this->serializer->deserialize($data, $type, $format, $context);

        // fire event  dispatch after dto created event
        $event = new AfterDtoCreatedEvent($dto);
        $this->eventDispatcher->dispatch($event, $event::NAME);
        // listeners to the event

        return $dto;
    }
}