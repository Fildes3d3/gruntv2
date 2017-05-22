<?php
/**
 * Created by PhpStorm.
 * User: Bogdan.Pop
 * Date: 2/14/2017
 * Time: 11:33 AM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class showController extends Controller
{
    /**
     * @Route("/{year}/{month}/{day}/{name}/", name="show")
     */
    public function showAction(Request $request, $name)
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
            3/*limit per page*/
        );

        $allposts = $query->getResult();


        /** @var \Ekino\WordpressBundle\Manager\PostManager $postManager */
        $postManager = $this->get('ekino.wordpress.manager.post');

        $criteria = [
            'name' => $name,
        ];
        $posts = $postManager->findOneBy($criteria);


        $criteria = [
            'post' => $posts->getId(),
            //'approved' => 1,
        ];
        $commentsManager = $this->get('ekino.wordpress.manager.comment');
        $comments = $commentsManager->findBy($criteria);

        $postId = [];
        foreach ($allposts as $value){
            $postId[] = $value->getId();
        }

        $repository = $this->get('ekino.wordpress.manager.term')->getRepository();

        $query = $repository->createQueryBuilder('x')
            ->select('x.name,x.slug,t.count as catcount')
            ->join('x.taxonomies', 't')
            ->where('t.taxonomy=:tx')
            ->setParameter('tx', 'category')
            ->getQuery();

        $categories = $query->getResult();

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

        $comment_author = '';
        if ( isset($_COOKIE['comment_author_'.COOKIEHASH]) )
            $comment_author = $_COOKIE['comment_author_'.COOKIEHASH];
        $comment_author_email = '';
        if ( isset($_COOKIE['comment_author_email_'.COOKIEHASH]) )
            $comment_author_email = $_COOKIE['comment_author_email_'.COOKIEHASH];
        $comment_author_url = '';
        if ( isset($_COOKIE['comment_author_url_'.COOKIEHASH]) )
            $comment_author_url = $_COOKIE['comment_author_url_'.COOKIEHASH];

        $finder = new Finder();
        $finder->files()->in('wordpress/wp-content/uploads/')->name('*.jpg')->size('> 80K');
        $dir = 'wordpress/wp-content/uploads/';

        foreach ($finder as $file) {
            $images[] =$dir . $file->getRelativePathname();
        }


        return $this->render('newTheme/show.html.twig', [
            'posts' => $posts,
            'comments' => $comments,
            'terms' => $res,
            'categories'=> $categories,
            'allposts' => $allposts,
            'comment_author' => $comment_author,
            'comment_author_email' => $comment_author_email,
            'comment_author_url' => $comment_author_url,
            'pagination' => $pagination,
            'images' => $images,
        ]);
    }
}