<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 19.04.18
 * Time: 11:34
 */

namespace kymbrik\src\model\local;

use kymbrik\src\model\Model;

class Feed implements Model
{
    public $id;
    public $feedName;
    public $link;
    /**
     * @var array[Dictionary]
     */
    public $dictionaries;

    public function __construct($data = null)
    {
        if (is_array($data)) {
            if (isset($data['id'])) {
                $this->id = $data['id'];
            }
            if (isset($data['feedName'])) {
                $this->feedName = $data['feedName'];
            }
            if (isset($data['link'])) {
                $this->link = $data['link'];
            }
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFeedName()
    {
        return $this->feedName;
    }

    /**
     * @param mixed $feedName
     */
    public function setFeedName($feedName)
    {
        $this->feedName = $feedName;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    public function setDictionaries(array $dictionaries)
    {
        $this->dictionaries = $dictionaries;
    }

    /**
     * @return array
     */
    public function getDictionaries(): array
    {
        return $this->dictionaries;
    }



}