<?php

namespace App\Controller;

use App\Entity\Asset;
use App\Manager\CoinApiManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class ApiController
 * @package App\Controller
 */

class ApiController extends AbstractController
{
    public $apiManager;

    public function __construct(CoinApiManager $apiManager) {
        $this->apiManager = $apiManager;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function saveAsset(ManagerRegistry $doctrine): JsonResponse
    {
        $responses = $this->apiManager->getAssets();

        foreach ($responses as $response)
        {
            $asset = new Asset();
            $asset->setName($response['name']);
            $asset->setPrice($response['price_usd'] ?? null);

            $doctrine->getManager()->persist($asset);
        }
        $doctrine->getManager()->flush();

        return new JsonResponse('Code: 0', Response::HTTP_OK);
    }

    public function getAssets(): JsonResponse
    {
        $arrayResponse = array();
        $assets = $this->apiManager->getAllAssets();

        foreach ($assets as $asset){
            $arrayResponse[] = array(
                'name' => $asset->getName(),
                'price' => $asset->getPrice()
            );
        }

        return new JsonResponse($arrayResponse, Response::HTTP_OK);
    }

    public function showAssets(): Response
    {
        $assets = $this->apiManager->getAllAssets();

        return $this->render(
            'list.html.twig',
            ['assets' => $assets]
        );
    }
}