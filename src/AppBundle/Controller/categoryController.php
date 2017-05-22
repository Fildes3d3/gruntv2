<?php
/**
 * Created by PhpStorm.
 * User: Bogdan.Pop
 * Date: 2/14/2017
 * Time: 1:47 PM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class categoryController extends Controller
{

    private $allterms = [];

    private function getCategories(array $catIds) {
        $res = $this->get('ekino.wordpress.manager.term_taxonomy')->findBy(['parent'=>$catIds]);

        $ids = [];
        foreach ($res as $value) {
            $id = $value->getTerm()->getId();
            $ids []= $id;
            $this->allterms [] = $id;
        }

        if (count($ids) > 0) {
            $this->getCategories($ids);
        }
    }

    /**
     * @Route("/category/{category_name}", name="category_archives")
     */
    public function categoryAction( Request $request, $category_name)
    {

        $cat = str_replace(" ", "-", $category_name);


        $catObj = $this->get('ekino.wordpress.manager.term')->findOneBy(['slug' => $cat]);

        $catId = $catObj->getId();

        $this->allterms [] = $catId;

        $this->getCategories([$catId]);


        $name = $cat;



        $repository = $this->get('ekino.wordpress.manager.post')->getRepository();

        $query = $repository->createQueryBuilder('p')
            ->where('p.status = :status')
            ->setParameter('status', 'publish')
            ->orderBy('p.date', 'DESC')
            ->getQuery();

        $posts = $query->getResult();

        $postId = [];
        foreach ($posts as $value){
            $postId[] = $value->getId();
        }


        $repository = $this->get('ekino.wordpress.manager.post')->getRepository();

        $query = $repository->createQueryBuilder('post')
            ->select('term.name,term.slug, IDENTITY(rel.parent)', 'post as posts')
            ->join('post.termRelationships', 'tx')
            ->join('tx.taxonomy', 'rel')
            ->join('rel.term', 'term')
            ->where('post in (:p)')
            ->andWhere('rel.parent in (:rel)')
            ->andwhere('term.slug = :name')
            ->setParameter('p', $postId)
            ->setParameter('rel', array(0,2))
            ->setParameter('name', $name)
            ->orderBy('post.date', 'DESC')
            ->getQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        $postByCat = $query->getResult();


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
            ->select('term.name,term.slug','IDENTITY(rel.parent)', 'post.id')
            ->join('post.termRelationships', 'tx')
            ->join('tx.taxonomy', 'rel')
            ->join('rel.term', 'term')
            ->where('post in (:p)')
            ->setParameter('p', $postId)
            ->getQuery();

        $res = $query->getResult();

        foreach ($postByCat as $value) {
            $postsbc[] = $value['posts'];
        }

        $finder = new Finder();
        $finder->files()->in('wordpress/wp-content/uploads/')->name('*.jpg')->size('> 80K');
        $dir = '/wordpress/wp-content/uploads/';

        foreach ($finder as $file) {
            $images[] =$dir . $file->getRelativePathname();
        }

        return $this->render('newTheme/category.html.twig', [

            'posts' => $postsbc,
            'name' => $name,
            'terms' => $res,
            'categories'=> $categories,
            'pagination' => $pagination,
            'images' => $images,

        ]);
    }

}