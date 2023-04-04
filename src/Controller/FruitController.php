<?php

namespace App\Controller;

use App\Repository\FruitRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FruitController extends AbstractController
{
    #[Route('/', name: 'app_fruit')]
    public function index(FruitRepository $fruitRepository, PaginatorInterface $paginator, Request $request)
    {
        // $queryBuilder = $repository->createQueryBuilder('f')
        //     ->orderBy('f.name', 'ASC');

        // // Filter fruits by name
        // $name = $request->query->get('name');
        // if ($name) {
        //     $queryBuilder
        //         ->where('f.name LIKE :name')
        //         ->setParameter('name', "%$name%");
        // }

        // // Filter fruits by family
        // $family = $request->query->get('family');
        // if ($family) {
        //     $queryBuilder
        //         ->andWhere('f.family = :family')
        //         ->setParameter('family', $family);
        // }

        // $pagination = $paginator->paginate(
        //     $queryBuilder->getQuery(),
        //     $request->query->getInt('page', 1),
        //     10 // items per page
        // );

        // return $this->render('fruit/index.html.twig', [
        //     'pagination' => $pagination,
        // ]);

        // return $this->render('fruit/index.html.twig', [
        //     'fruits' => $pagination,
        // ]);

        // //$fruits = $fruitRepository->findAll();
 
        // var_dump($fruits);
        // return $this->render('fruit/index.html.twig', [
        //     'controller_name' => 'FruitController',
        // ]);

        $fruits = $fruitRepository->findAll();

        $fruitsPagination = $paginator->paginate(
            $fruits,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('fruit/index.html.twig', [
            'fruits' => $fruitsPagination
        ]);

    }
}
