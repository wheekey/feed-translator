<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 12.05.18
 * Time: 13:21
 */

namespace kymbrik\src\api;

use kymbrik\src\model\local\Dictionary;
use kymbrik\src\model\local\Feed;

class Api
{
    public function getFeeds()
    {
        $feedsRepository = new \kymbrik\src\repository\local\FeedsRepository();
        $dictionariesRepository = new \kymbrik\src\repository\local\DictionariesRepository();

        $feeds = $feedsRepository->findAll();
        $dictionaries = $dictionariesRepository->findAll();

        foreach ($feeds as $feed) {
            $feed->setDictionaries($dictionariesRepository->findAllByFeedId($feed->getId()));
        }

        $result = [];
        $result["feeds"] = $feeds;
        $result["dictionaries"] = $dictionaries;

        echo json_encode($result);
    }

    public function deleteFeed()
    {
        //$entityBody = json_decode('{"id":1,"feedName":"Feed1","link":"http:\/\/feed1.ru","dictionaries":[{"id":2,"language":"french","fileName":"french1.txt"},{"id":1,"language":"english","fileName":"english1.txt"}]}', true);
        $entityBody = json_decode(file_get_contents('php://input'), true);
        $feedsRepository = new \kymbrik\src\repository\local\FeedsRepository();
        $feedDictRelationsRepository = new \kymbrik\src\repository\local\FeedDictRelationsRepository();
        $feedDictRelationsRepository->deleteRelationsByFeedId($entityBody["id"]);
        $feedsRepository->deleteByFeedId($entityBody["id"]);

        echo "success";
    }

    public function setFeedDict()
    {
        $dictionariesRepository = new \kymbrik\src\repository\local\DictionariesRepository();
        $feedDictRelationsRepository = new \kymbrik\src\repository\local\FeedDictRelationsRepository();
        $entityBody = json_decode(file_get_contents('php://input'), true);

        //Найдем словари с определенным языком
        $dicts = $dictionariesRepository->findAllByLanguage($entityBody["language"]);

        //Поудаляем все позиции, что связаны с данным feedId и dictIds
        foreach ($dicts as $dict) {
            $feedDictRelationsRepository->delete($entityBody["feedId"], $dict->getId());
        }

        $feedDictRelationsRepository->save($entityBody["feedId"], $entityBody["languageId"]);
    }

    public function updateFeedLink()
    {
        $entityBody = json_decode(file_get_contents('php://input'), true);
        $feedsRepository = new \kymbrik\src\repository\local\FeedsRepository();
        $feed = $feedsRepository->findByFeedId($entityBody["feedId"]);
        $feed->setLink($entityBody["feedLink"]);
        $feedsRepository->update($feed);
    }

    public function uploadDictionary()
    {
        error_reporting(0);
        $dictionariesRepository = new \kymbrik\src\repository\local\DictionariesRepository();
        $filename = !empty($_POST["filename"]) ? $_POST["filename"] : $_POST["language"] . "_" . date("Y-m-d");
        $destination = getenv("APP_DIR") . getenv("FILES_DIR") . "/dictionary/" . $_POST["language"] . "/" . $filename;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
            $dictionariesRepository->save(new Dictionary(["language" => $_POST["language"], "fileName" => $filename]));
            echo '{"response": "Success"}';
        } else {
            echo '{"response": "Failure", "error": "Error while uploading file"}';
        }
    }

    public function addFeed()
    {
        error_reporting(0);
        $feedsRepository = new \kymbrik\src\repository\local\FeedsRepository();
        if ($feedsRepository->save(new Feed(["feedName" => $_POST["feedName"]]))) {
            echo '{"response": "Success"}';
        } else {
            echo '{"response": "Failure", "error": "Error while uploading file"}';
        }
    }

    public function getLanguageList()
    {
        $dictionariesRepository = new \kymbrik\src\repository\local\DictionariesRepository();
        $dicts = $dictionariesRepository->findAllWithDistinctLanguages();

        $response = [];

        foreach ($dicts AS $dict) {
            $response[] = $dict->getLanguage();
        }

        echo json_encode($response);
    }
}