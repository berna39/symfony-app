<?php

namespace App\MessageHandler;

use App\Message\DataNotification;
use App\Entity\Article;
use App\Repository\ArticleRepository;

class DataNotificationHandler
{
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function __invoke(DataNotification $dataNotification)
    {   
        $newArticle = $dataNotification->getArticle();
        $exists = $this->articleRepository->findOneBy(['title' => $newArticle->title]);

        if($exists != null)
        {
            $exists->setTitle($newArticle->title)
                    ->setShortDescription($newArticle->shortDescription)
                    ->setPicture($newArticle->picture)
                    ->setUpdatedAt(new \DateTime('now'));

            $this->articleRepository->update($exists);
            echo "Updated ". PHP_EOL;

            
        }
        else
        {
            $article = new Article;
            $article->setTitle($newArticle->title)
                    ->setShortDescription($newArticle->shortDescription)
                    ->setPicture($newArticle->picture);
            $this->articleRepository->add($article, true);
            echo "New article loaded".PHP_EOL;
        }
    }
} 
