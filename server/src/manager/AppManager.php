<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 16.05.18
 * Time: 14:56
 */

namespace kymbrik\src\manager;


use kymbrik\src\entity\DictionaryFile;
use kymbrik\src\entity\FileExtension;
use kymbrik\src\entity\FileType;
use kymbrik\src\entity\Language;
use Psr\Log\LoggerInterface;

class AppManager
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function test()
    {
        $this->logger->info("Оформляем заказ по кадастровому номеру.");

    }

    /**
     * Основной метод, который мы будем запускать по крону
     */
    public function translateFeeds()
    {
        //TODO на данный момент будем предполагать, что все фиды у нас XML
        $feedsRepository = new \kymbrik\src\repository\local\FeedsRepository();
        $dictionariesRepository = new \kymbrik\src\repository\local\DictionariesRepository();
        $feeds = $feedsRepository->findAll();

        foreach ($feeds as $feed) {
            $feed->setDictionaries($dictionariesRepository->findAllByFeedId($feed->getId()));
        }

        foreach ($feeds as $feed) {
            foreach ($feed->getDictionaries() as $dictionary) {
                $dictionaryFile = new DictionaryFile($dictionary->getFileName(), new FileType (FileType::DICTIONARY), new FileExtension(FileExtension::EMPTY),
                    new Language($dictionary->getLanguage()));
                $feedFile = new \kymbrik\src\entity\FeedFile($feed->getFeedName(), new FileType (FileType::FEED), new FileExtension(FileExtension::XML));
                //Загрузим новый фид
                $feedFile->uploadFile($feed->getLink());
                $translator = new \kymbrik\src\utility\XMLTranslator($dictionaryFile, $feedFile);
                $translator->translate();
            }
        }
    }

}