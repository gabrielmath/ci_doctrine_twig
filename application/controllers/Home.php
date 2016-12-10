<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Entity\Category;
use Entity\Post;

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Twig');
    }

    public function index()
    {
        $postRepository = $this->doctrine->em->getRepository(Post::class);
        $categoryRepository = $this->doctrine->em->getRepository(Category::class);        
        $categories = $categoryRepository->findAll();

        $search = (int) $this->uri->segment(3);
        if(isset($search) and $search != '')
        {
            $queryBuilder = $postRepository->createQueryBuilder('p');
            $queryBuilder->join('p.categories', 'c')
                        ->where($queryBuilder->expr()->eq('c.id', $search));
            $posts = $queryBuilder->getQuery()->getResult();
        }
        else
        {
            $posts = $postRepository->findAll();
        }
        
        $data = array(
            'categories' => $categories,
            'posts' => $posts
        );

        $this->twig->display('home.twig', $data);
    }

}