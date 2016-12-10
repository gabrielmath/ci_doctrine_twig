<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Entity\Category;
use Entity\Post;

class Categories extends CI_Controller
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



    public function lists()
    {
        $repository = $this->doctrine->em->getRepository(Category::class);
        $categories = $repository->findAll();

        $this->twig->display('categories.list.twig', ['categories' => $categories]);
    }
    
    public function create()
    {
        $this->twig->display('categories.create.twig');
    }
    
    public function insert()
    {
        /*
         * TRATAMENTO DE DADOS AQUI
         */

        $name = $this->input->post('name');

        $category = new Category();
        $category->setName($name);
        $this->doctrine->em->persist($category);
        $this->doctrine->em->flush();
        redirect('/categories/lists/');
    }

    public function edit()
    {
        $id = (int) $this->uri->segment(3);
        if($id == null || $id == '')
        {
            redirect('/categories/lists/');
        }
        else
        {
            $repository = $this->doctrine->em->getRepository(Category::class);
            $category = $repository->find($id);

            $this->twig->display('categories.edit.twig',['category' => $category]);
        }
    }

    public function update()
    {
        $id = (int) $this->uri->segment(3);
        if($id == null || $id == '')
        {
            redirect('/categories/lists/');
        }
        else
        {
            $name = $this->input->post('name');

            $repository = $this->doctrine->em->getRepository(Category::class);
            $category = $repository->find($id);
            $category->setName($name);

            $this->doctrine->em->flush();

            redirect('/categories/lists/');
        }
    }

    public function remove()
    {
        $id = (int) $this->uri->segment(3);
        if($id == null || $id == '')
        {
            redirect('/categories/lists/');
        }
        else
        {
            $repository = $this->doctrine->em->getRepository(Category::class);
            $category = $repository->find($id);

            $this->doctrine->em->remove($category);
            $this->doctrine->em->flush();

            redirect('/categories/lists/');
        }
    }

}
















