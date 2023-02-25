<?php

namespace App\Controller;

use App\DTO\LowestPriceEnquiry;
use App\Filter\promotionsFilterInterface;
use App\Service\Serializer\DTOSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProductsController extends AbstractController
{
    #[Route('/products/{id}/lowest-price', name: 'lowest-price', methods: 'POST')]
    public function lowestPrice(Request $request, int $id, promotionsFilterInterface $promotionsFilter, DTOSerializer $serializer): Response
    {
        if ($request->headers->has('force_fail')) {

            return new JsonResponse(
                ['error' => 'Promotions Engine failure message'],
                $request->headers->get('force_fail')
            );
        }


        // 1. deserialize json data into a LowestPriceEnquiry


        // explain auto wiring using serializer
        // auto wiring when we use the interface promotionsFilterInterface the container serive ioc  will check for who impelent it
        // will find only one class use it then will crete an object using the dependy injection

        // public function SerializerInterface::deserialize(mixed $data, string $type, string $format, array $context = []) mixed
        /** @var LowestPriceEnquiry $lowestPriceEnquiry */
        $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiry::class, "json");


        // 2. pass the Enquiry into a Promotion filter
        // this appropriate promotion will be applied

        $modifiedEnquiry = $promotionsFilter->apply($lowestPriceEnquiry);

        // 3. return the modified Enquiry

        $responseContent = $serializer->serialize($modifiedEnquiry, "json");
        return new Response($responseContent, 200);
    }


    #[Route('/products/{id}/promotions', name: 'promotions', methods: 'GET')]
    public function promotions()
    {

    }
}