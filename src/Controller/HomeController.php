<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(TrickRepository $trickRepository): Response
    {
        /*$allTricks = [
            "trick1" => [
                "id" => 1,
                "name" => "mute",
                "image"=> "/img/mute.png"
            ],
            "trick2" => [
                "id" => 2,
                "name" => "flip",
                "image"=> "/img/flip.jpg"
            ]
        ];

        return $this->render('home/index.html.twig', [
            'allTricks' => $allTricks
        ]);*/
        return $this->render('trick/index.html.twig', [
            'tricks' => $trickRepository->findAll(),
        ]);
    }
}
