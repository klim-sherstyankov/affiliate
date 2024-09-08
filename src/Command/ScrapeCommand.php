<?php

namespace App\Command;

use App\Entity\Items;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class ScrapeCommand extends Command
{
    protected static $defaultName = 'app:scrape';

    protected EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct();

        $this->manager = $manager;
    }

    protected function configure(): void
    {
        $this->setDescription('Scrapes data from a website');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://www.pepper.ru/new');

        $htmlContent = $response->getContent();
        $crawler = new Crawler($htmlContent);
        $strongTags = $crawler->filter('article');

        foreach ($strongTags as $i => $strongTag) {
            $linkHref = null;
            $linkText = null;
            $price = null;
            $priceOffPercent = null;
            $img = null;
            $salePriceText = null;

            $strongCrawler = new Crawler($strongTag);
            $links = $strongCrawler->filter('a');

            foreach ($links as $i => $link) {
                if ($i > 0) {
                    continue;
                }

                $linkText = $link->textContent;
                $linkHref = $link->getAttribute('href');
            }

            $salePrices = $strongCrawler->filter('.thread-price');

            foreach ($salePrices as $i => $salePrice) {
                if ($i > 0) {
                    continue;
                }

                $salePriceText = (int) str_replace(' ', '', $salePrice->textContent);
            }

            $prices = $strongCrawler->filter('.mute--text');

            foreach ($prices as $i => $pr) {
                if ($i > 0) {
                    continue;
                }

                $price = (int) str_replace(' ', '', $pr->textContent);
            }

            $priceOffPercents = $strongCrawler->filter('.space--ml-1');

            foreach ($priceOffPercents as $i => $priceOff) {
                if ($i > 0) {
                    continue;
                }

                $priceOffPercent = (int) preg_replace('/[^0-9]/', '', $priceOff->textContent);
            }

            $imgFrames = $strongCrawler->filter('.thread-image');

            foreach ($imgFrames as $i => $imgFrame) {
                if ($i > 0) {
                    continue;
                }

                $img = $imgFrame->getAttribute('src');
            }

            if (!$linkHref || !$linkText || !$price || !$priceOffPercent || !$img || !$salePriceText) {
                continue;
            }

            /** @var Items $item */
            $item = $this->manager->getRepository(Items::class)->findOneBy(['url' => $linkHref]);

            if (null !== $item) {
                continue;
            }

            $product = new Items();
            $product->setUrl($linkHref);
            $product->setDescription($linkText);
            $product->setPrice($salePriceText);
            $product->setPriceOffPercent($priceOffPercent);
            $product->setShortName($linkText);
            $product->setImage($img);
            $product->setShopName(null);
            $product->setSalePrice($price);
            $product->setShopId(null);
            $this->manager->persist($product);

            $this->manager->flush();
        }

        return Command::SUCCESS;
    }
}
