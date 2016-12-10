<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Entity\Category;
class Welcome extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Twig');
    }

    /**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function teste()
	{
		$repository = $this->doctrine->em->getRepository(Category::class);
		$categories = $repository->findAll();

		$data['categories'] = $categories;

        $data['title'] = "Minha View Twig";
        $this->twig->display('teste.twig', $data);

	}

}
