<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/trick')]
class TrickController extends AbstractController
{
    #[Route('/new', name: 'app_trick_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TrickRepository $trickRepository): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        // dd($form);

        if ($form->isSubmitted() && $form->isValid()) {
            $trickRepository->save($trick, true);
            $this->addFlash(
                'notice',
                "Your trick has been created!"
            );

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trick_show', methods: ['GET'])]
    public function show(Trick $trick, CommentRepository $commentRepository): Response
    {
        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'comments' => $commentRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_trick_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach($trick->getImages() as $image) {
            // Add an image->Exception : 
            // "Typed property App\Entity\Image::$name must not be accessed before initialization":
            // Ajouter une condition pour vérifier si les nom de l'image est créée? dans db? dans form?
            //     if(property_exists($image, "name") && $image->getName() === null) {
                // $name = '';
                // $name = $image->getName();
                // dd($name);
            }
            $trickRepository->save($trick, true);

            $this->addFlash(
                'notice',
                "Your trick has been updated!"
            );

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trick_delete', methods: ['POST'])]
    public function delete(Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $trickRepository->remove($trick, true);
        }
        $this->addFlash(
            'notice',
            "Your trick has been deleted!"
        );

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
