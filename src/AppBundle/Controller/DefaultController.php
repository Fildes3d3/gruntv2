<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\Finder;
use Symfony\Component\VarDumper\VarDumper;

class DefaultController extends Controller
{
    /**
     * @Route("/administrator", name="administrator")
     */
    public function adminAction()
    {
        $security = $this->get('security.token_storage');
        $token = $security->getToken();
        if ($token->getUsername() == 'anon.') {
            return $this->redirect('/login');
        }

        return $this->redirect('/wordpress/wp-admin');
    }


    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->get('ekino.wordpress.manager.post')->getRepository();

        $query = $repository->createQueryBuilder('p')
            ->where('p.status = :status')
            ->setParameter('status', 'publish')
            ->orderBy('p.date', 'DESC')
            ->getQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );

        $posts = $query->getResult();

        $postId = [];
        foreach ($posts as $value){
            $postId[] = $value->getId();
        }


        $repository = $this->get('ekino.wordpress.manager.post')->getRepository();

        $query = $repository->createQueryBuilder('post')
            ->select('term.name,term.slug', 'post.id')
            ->join('post.termRelationships', 'tx')
            ->join('tx.taxonomy', 'rel')
            ->join('rel.term', 'term')
            ->where('post in (:p)')
            ->setParameter('p', $postId)
            ->getQuery();

        $res = $query->getResult();




       $repository = $this->get('ekino.wordpress.manager.term')->getRepository();

       $query = $repository->createQueryBuilder('x')
           ->select('x.name,x.slug,t.count as catcount')
           ->join('x.taxonomies', 't')
           ->where('t.taxonomy=:tx')
           ->setParameter('tx', 'category')
           ->getQuery();

       $categories = $query->getResult();

        $finder = new Finder();
        $finder->files()->in('wordpress/wp-content/uploads/')->name('*.jpg')->size('> 150K');
        $dir = 'wordpress/wp-content/uploads/';

        foreach ($finder as $file) {
            $images[] =$dir . $file->getRelativePathname();
        }


        return $this->render('newTheme/index.html.twig', [
            'posts' => $posts,
            'terms' => $res,
            'categories'=> $categories,
            'pagination' => $pagination,
            'images' => $images,

        ]);

    }
}
