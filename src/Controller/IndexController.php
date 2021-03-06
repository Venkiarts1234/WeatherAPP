<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController {

    /**
     * @Route("/", name="homepage")
     */
    public function index(Type $var = null)
    {
        return $this->render('utilities/SearchBar.html.twig');
    }
}