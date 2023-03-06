<?php

namespace App\EventSubscriber;

use App\Event\AfterDtoCreatedEvent;
use App\Service\ServiceException;
use App\Service\ValidationExceptionData;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DtoSubscriber implements EventSubscriberInterface
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterDtoCreatedEvent::NAME => 'validateDto'
        ];
    }

    public function validateDto(AfterDtoCreatedEvent $event)
    {
        $dto = $event->getDto();
        $errors = $this->validator->validate($dto);


        if (count($errors) > 0) {
            $validationExceptionData = new ValidationExceptionData(422, 'ConstraintViolationList', $errors);
            throw new ServiceException($validationExceptionData);
        }

        // validate the dto
    }


    public function doSomethingElse(AfterDtoCreatedEvent $event)
    {
        dd($event::NAME);
    }


}
