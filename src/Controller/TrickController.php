<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trick')]
class TrickController extends AbstractController
{
    #[Route('/new', name: 'app_trick_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TrickRepository $trickRepository): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trickRepository->save($trick, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trick_show', methods: ['GET'])]
    public function show(Trick $trick): Response
    {
        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_trick_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trickRepository->save($trick, true);

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

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
