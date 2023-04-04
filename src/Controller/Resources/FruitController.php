<?php

namespace App\Controller\Resources;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; 
use App\Repository\FruitRepository;
use Exception;

class FruitController extends AbstractController
{ 
    public $fruitRepository; 
    public function __construct(FruitRepository $fruitRepo){
        $this->fruitRepository = $fruitRepo;
    }
    public function index(Request $request): Response
    {
        try{
            $page = $request->query->getInt('page', 1);
            $pageSize = $request->query->getInt('pageSize', 10);

            $fruits = $this->fruitRepository->findBy([], null, $pageSize, ($page - 1) * $pageSize);
            $totalItems = $this->fruitRepository->count([]);
            return $this->json([
                'message' => 'fruit list',
                'data' => [
                    'items' => $fruits,
                    'totalItems' => $totalItems,
                    'page' => $page,
                    'pageSize' => $pageSize,
                ],
            ],
            200);  

        }catch(Exception $e){

            return $this->json([ 
                'message' => $e->getMessage(),
            ],500); 

        }
    }
}
