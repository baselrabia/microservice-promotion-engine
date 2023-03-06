<?php

namespace App\Event;

use App\DTO\PromotionEnquiryInterface;
use Symfony\Contracts\EventDispatcher\Event;

class AfterDtoCreatedEvent extends  Event
{
//    public const NAME = 'what.doing'
    public const NAME = 'dto.created';

    public function __construct(protected PromotionEnquiryInterface $dto)
    {
    }

    /**
     * @return PromotionEnquiryInterface
     */
    public function getDto(): PromotionEnquiryInterface
    {
        return $this->dto;
    }

}