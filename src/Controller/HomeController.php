<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $allTricks = [
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
        ]);
    }
}
