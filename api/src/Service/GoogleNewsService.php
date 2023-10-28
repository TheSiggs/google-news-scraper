<?php

namespace App\Service;

use App\Entity\GoogleNews;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;

readonly class GoogleNewsService {
    public function __construct(private EntityManagerInterface $entityManager){}

    public function scrap(string $query, string $apiKey, int $results): array {
        $client = Client::createChromeClient(arguments: [
            '--no-sandbox',
            '--disable-dev-shm-usage',
            '--headless'
        ]);
        $crawler = $client->request('GET', sprintf('https://www.google.com/search?q=%s&tbm=nws&num=%d', $query, $results));
        $collection = [];
        $crawler->filter('#rso > div > div > div')->each(function (Crawler $c, $i) use ($apiKey, $query, &$collection) {
            $element = $c->filter('div > div > a');
            $url = $element->getAttribute('href');
            try {
                $image = $element->filter('div > div > div > div > img')->getAttribute('src');
//                $image = $this->saveImage($image);
                $title = $element->filter('div > div:nth-child(2) > div:nth-child(2)')->getText();
                $snippet = $element->filter('div > div:nth-child(2) > div:nth-child(3)')->getText();
                $newsOutlet = $element->filter('div > div:nth-child(2) > div > span')->getText();
                $age = $element->filter('div > div:nth-child(2) > div:nth-child(5) > span')->getText();
            } catch (\Exception $e) {
                $title = $element->filter('div > div > div:nth-child(2)')->getText();
                $snippet = $element->filter('div > div > div:nth-child(3)')->getText();
                $newsOutlet = $element->filter('div > div > div > span')->getText();
                $age = $element->filter('div > div > div:nth-child(5) > span')->getText();
                $image = '';
            }

            $result = new GoogleNews();
            $result->setQuery($query);
            $result->setPosition($i);
            $result->setLink($url);
            $result->setThumbnail($image);
            $result->setTitle($title);
            $result->setSnippet($snippet);
            $result->setSource($newsOutlet);
            $result->setDate($age);
            $result->setCreated(new DateTime());
            $result->setUser($apiKey);
            $this->entityManager->persist($result);
            $collection[] = $result;
        });
        $this->entityManager->flush();
        return $collection;
    }

    private function saveImage(string $img): string {
        $extension = strstr($img, ';', true);
        $extension = strstr($extension, '/');
        $extension = substr($extension,  1);
        $newFilename = 'searches/images/' . uniqid('', true) . uniqid('', true) . '.' . $extension;

        $source = fopen($img, 'rb');
        $destination = fopen($newFilename, 'wb');

        stream_copy_to_stream($source, $destination);

        fclose($source);
        fclose($destination);
        return $newFilename;
    }
}
