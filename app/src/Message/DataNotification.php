<?php

namespace App\Message;

class DataNotification
{
    private $article;

    public function __construct(\stdClass $article)
    {
        $this->article = $article;
    }

    public function getArticle(): \stdClass
    {
        return $this->article;
    }
}
