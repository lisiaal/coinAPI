<?php

namespace App\Manager;

use App\Dto\ApiDto;
use App\Entity\Asset;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CoinApiManager
{
    private $client;

    private $em;

    public function __construct(HttpClientInterface $client, ManagerRegistry $doctrine)
    {
        $this->client = $client;
        $this->em = $doctrine;
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getAssets(): array
    {
        $response = $this->client->request(
            'GET',
            'https://rest.coinapi.io/v1/assets', [
                'headers' => [
                    'Accept' => 'application/json',
                    'X-CoinAPI-Key' => 'BF5E262A-FDE6-4848-B29B-DF246D1ED135'
                ],
            ]
        );

        return $response->toArray();
    }

    public function getAllAssets(): array
    {
        return $this->em->getRepository(Asset::class)->findAll();
    }
}