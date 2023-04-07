<?php

namespace App\Controller;

use App\Repository\FruitRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{ 
    public function index(FruitRepository $fruitRepository, PaginatorInterface $paginator, Request $request)
    {

        return $this->render('fruit/index.html.twig'); 

    } 
    
}
