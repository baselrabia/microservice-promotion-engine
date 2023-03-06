<?php

namespace App\Tests\unit;

use App\DTO\LowestPriceEnquiry;
use App\Event\AfterDtoCreatedEvent;
use App\Service\ServiceException;
use App\Tests\ServiceTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class DtoSubscriberTest extends ServiceTestCase
{
    /** @test */
    public function a_dto_is_validated_after_it_has_been_created(): void
    {
        // given
        $dto = new LowestPriceEnquiry();
        $dto->setQuantity(-5);

        $event = new AfterDtoCreatedEvent($dto);
        /** @var EventDispatcherInterface $eventDispatcher */
        $eventDispatcher = $this->container->get("debug.event_dispatcher");

        // Expect
        $this->expectException(ServiceException::class);
        $this->expectExceptionMessage('ConstraintViolationList');

        // when
        $eventDispatcher->dispatch($event, $event::NAME);




        // then

    }
}