<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Entity\Category;
use Entity\Post;

class Posts extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Twig');
    }

    public function index()
    {
        redirect('/');
    }

    public function post()
    {
        $id = $this->uri->segment(3);
        $repository = $this->doctrine->em->getRepository(Post::class);
        $post = $repository->find($id);

        $this->twig->display('post.twig',['post' => $post]);
    }

    public function lists()
    {
        $repository = $this->doctrine->em->getRepository(Post::class);
        $posts = $repository->findAll();

        $this->twig->display('posts.list.twig', ['posts' => $posts]);
    }
    
    public function create()
    {
        $this->twig->display('posts.create.twig');
    }
    
    public function insert()
    {
        /*
         * TRATAMENTO DE DADOS AQUI
         */

        $title = $this->input->post('title');
        $content = $this->input->post('content');

        $post = new Post();
        $post->setTitle($title);
        $post->setContent($content);
        $this->doctrine->em->persist($post);
        $this->doctrine->em->flush();
        redirect('/posts/lists/');
    }

    public function edit()
    {
        $id = (int) $this->uri->segment(3);
        if($id == null || $id == '')
        {
            redirect('/posts/lists/');
        }
        else
        {
            $repository = $this->doctrine->em->getRepository(Post::class);
            $post = $repository->find($id);

            $this->twig->display('posts.edit.twig',['post' => $post]);
        }
    }

    public function update()
    {
        $id = (int) $this->uri->segment(3);
        if($id == null || $id == '')
        {
            redirect('/posts/lists/');
        }
        else
        {
            $title = $this->input->post('title');
            $content = $this->input->post('content');

            $repository = $this->doctrine->em->getRepository(Post::class);
            $post = $repository->find($id);
            $post->setTitle($title);
            $post->setContent($content);

            $this->doctrine->em->flush();

            redirect('/posts/lists/');
        }
    }

    public function remove()
    {
        $id = (int) $this->uri->segment(3);
        if($id == null || $id == '')
        {
            redirect('/posts/lists/');
        }
        else
        {
            $repository = $this->doctrine->em->getRepository(Post::class);
            $post = $repository->find($id);

            $this->doctrine->em->remove($post);
            $this->doctrine->em->flush();

            redirect('/posts/lists/');
        }
    }

    public function categories()
    {
        $id = (int) $this->uri->segment(3);
        if($id == null || $id == '')
        {
            redirect('/posts/lists/');
        }
        else
        {
            $repository = $this->doctrine->em->getRepository(Post::class);
            $categoryRepository = $this->doctrine->em->getRepository(Category::class);
            $categories = $categoryRepository->findAll();
            $post = $repository->find($id);

            $data = array(
                'categories' => $categories,
                'post' => $post
            );

            $this->twig->display('posts.categories.twig', $data);
        }
    }
    
    public function set_categories()
    {
        $id = (int) $this->uri->segment(3);
        if($id == null || $id == '')
        {
            redirect('/posts/lists/');
        }
        else
        {
            $repository = $this->doctrine->em->getRepository(Post::class);
            $categoryRepository = $this->doctrine->em->getRepository(Category::class);

            /** @var Post $post  */
            $post = $repository->find($id);
            $post->getCategories()->clear();
            $this->doctrine->em->flush();

            foreach($this->input->post('categories') as $idCategory)
            {
                $category = $categoryRepository->find($idCategory);
                $post->addCategory($category);
            }

            $this->doctrine->em->flush();
            redirect('/posts/lists/');
        }
    }
}
















