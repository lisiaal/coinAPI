<?php

namespace App\Controller;

use App\Entity\Asset;
use App\Manager\CoinApiManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class ApiController
 * @package App\Controller
 */

class ApiController
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
    public function saveAsset(ManagerRegistry $doctrine): string
    {
        $responses = $this->apiManager->getAssets();

        foreach ($responses as $response)
        {
            $asset = new Asset();
            $asset->setName($response['name']);
            $asset->setPrice($response['price_usd']?? null);

            $doctrine->getManager()->persist($asset);
        }
        $doctrine->getManager()->flush();

        return 'Code: 0';
    }

    public function getAssets()
    {

    }
}