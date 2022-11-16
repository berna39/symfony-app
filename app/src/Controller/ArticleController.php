<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Entity\Article;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="app_articles")
     */
    public function index(ArticleRepository $articleRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $articles = $articleRepository->findAll();
        $pagination = $paginator->paginate(
            $articles, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('article/index.html.twig', ['articles' => $pagination]);
    }

    /**
     * @Route("/delete/{id}", name="app_articles_delete", requirements={"id"="\d+"})
     */
    public function delete(int $id, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->findOneBy(['id' => $id]);
        $articleRepository->remove($article, true);
        return $this->redirect('/articles');
    }
}
