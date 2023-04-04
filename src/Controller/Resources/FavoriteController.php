<?php

namespace App\Controller\Resources;

use App\Entity\Fruit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; 
use App\Repository\FruitRepository;
use Exception; 

class FavoriteController extends AbstractController
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

            $fruits = $this->fruitRepository->findBy(['favorite' => 1], null, $pageSize, ($page - 1) * $pageSize);
            $totalItems = $this->fruitRepository->count(['favorite' => 1]);
            
            return $this->json([
                'message' => 'favorite fruits list',
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

    public function store(Request $request,EntityManagerInterface $entityManager)
    {
        
        try{
            
            $post_data = json_decode($request->getContent(), true);
            $id = $post_data['id'];  

            $fruit = $entityManager->getRepository(Fruit::class)->find($id);

            if ( !$fruit ) {
                throw $this->createNotFoundException(
                    'No fruit found for id '.$id
                );
            }  
            if( $fruit->favorite === true ){
                
                $fruit->setFavorite(false);
                $entityManager->flush(); 
                return $this->json([
                    'message' => 'fruit has been removed from favorite list.', 
                ],
                201); 
            } 
                 
            $fruit->setFavorite(true);
            $entityManager->flush(); 
            return $this->json([
                'message' => 'fruit has been added into favorite list.', 
            ],
            201);  

        }catch(Exception $e){

            return $this->json([ 
                'message' => $e->getMessage(),
            ],500); 

        }
    }
}
