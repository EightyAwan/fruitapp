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
            
            $totalProtein = $this->fruitRepository 
            ->createQueryBuilder('f');
            $totalProtein->select('SUM(f.protein) as total_protein, SUM(f.fat) as total_fat, SUM(f.calories) as total_calories, SUM(f.sugar) as total_sugar');
            $totalProtein->where('f.favorite = :favorite');
            $totalProtein->setParameter('favorite', 1);
            $totalProteinResult = $totalProtein->getQuery()->getScalarResult()[0]; 

            $totalFruitDiet = array(
                'total_protein' => $totalProteinResult['total_protein'],
                'total_fat' => $totalProteinResult['total_fat'],
                'total_calories' => $totalProteinResult['total_calories'],
                'total_sugar' => $totalProteinResult['total_sugar'],
            );  

            return $this->json([
                'message' => 'favorite fruits list',
                'data' => [
                    'items' => $fruits,
                    'totalItems' => $totalItems,
                    'totalFruitDiet' => $totalFruitDiet,
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
                    'favorite' => false
                ],
                201); 
            } 
                 
            $fruit->setFavorite(true);
            $entityManager->flush(); 
            return $this->json([
                'message' => 'fruit has been added into favorite list.', 
                'favorite' => true
            ],
            201);  

        }catch(Exception $e){

            return $this->json([ 
                'message' => $e->getMessage(),
            ],500); 

        }
    }
}
