<?php
/**
 * Created by PhpStorm.
 * User: Bogdan.Pop
 * Date: 2/14/2017
 * Time: 12:07 PM
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class authorArchivesController extends Controller
{
    /**
     * @Route("/author/{author_name}", name="author_archives")
     */
    public function authorAction( Request $request, $author_name)
    {
        $criteria = [
          'nicename' => $author_name
        ];

        $user = $this->get('ekino.wordpress.manager.user')->findOneBy($criteria);

        $author = $user->getId();


        $repository = $this->get('ekino.wordpress.manager.post')->getRepository();

        $query = $repository->createQueryBuilder('p')
            ->where('p.status = :status')
            ->andwhere('p.author = :author')
            ->setParameter('status', 'publish')
            ->setParameter('author', $author)
            ->orderBy('p.date', 'DESC')
            ->getQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        $posts = $query->getResult();

        $repository = $this->get('ekino.wordpress.manager.post')->getRepository();
        $terms_arr=[];
        foreach ($posts as $p) {
            $query = $repository->createQueryBuilder('posts')
                ->select('term.name as term_name')
                ->join('posts.termRelationships', 'p')
                ->join('p.taxonomy', 'taxonomy')
                ->join('taxonomy.term', 'term')
                ->where('posts.id=:p')
                ->setParameter('p',$p)
                ->getQuery();
            $terms = ($query->getResult());
            $terms_array=[];
            foreach ($terms as $t){
                $terms_array[]=$t['term_name'];
                $terms_arr[$p->getId()]=$terms_array;
            }
        }

        $categories = $this->get('ekino.wordpress.manager.term_taxonomy')->getRepository()
            ->findBy(array('taxonomy'=>'category'));
        $cate=[];
        foreach ($categories as $value) {
            $cate[] = $value->getTerm();

        }

        $query = $repository->createQueryBuilder('p')
            ->select('DISTINCT DATE_FORMAT(p.date, \'%M %Y\')')
            ->where('p.status = :status')
            ->setParameter('status', 'publish')
            ->getQuery();

        $allmonths = $query->getResult();

        return $this->render('default/author_archives.html.twig', [
            'posts' => $posts,
            'term' => $terms_arr,
            'user' => $user,
            'categories'=> $cate,
            'pagination' => $pagination,
            'allmonths' => $allmonths,
        ]);

    }
}