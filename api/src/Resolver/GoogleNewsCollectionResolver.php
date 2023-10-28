<?php

namespace App\Resolver;

use ApiPlatform\GraphQl\Resolver\QueryCollectionResolverInterface;
use App\Service\GoogleNewsService;
use Doctrine\ORM\EntityManagerInterface;

readonly class GoogleNewsCollectionResolver implements QueryCollectionResolverInterface {

    public function __construct(private EntityManagerInterface $entityManager){}

    public function __invoke(?iterable $collection, array $context): iterable {
        // TODO Authenticate API key
        $apiKey = $context['args']['api_key'] ?? '';
        $query = $context['args']['query'];
        $results = $context['args']['results'] ?? 10;
        return (new GoogleNewsService($this->entityManager))->scrap($query, $apiKey, $results);
    }
}
