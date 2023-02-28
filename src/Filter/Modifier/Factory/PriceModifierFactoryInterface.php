<?php

namespace App\Filter\Modifier\Factory;

interface PriceModifierFactoryInterface
{

    public function create(?string $getType);
}