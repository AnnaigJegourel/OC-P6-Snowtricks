<?php

namespace App\Controller;

use App\Entity\Trick;
use DateTimeImmutable;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Repository\TrickRepository;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/trick')]
class TrickController extends AbstractController
{
    // CREATE
    #[Route('/new', name: 'app_trick_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TrickRepository $trickRepository): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $now = new DateTimeImmutable();
            $trick->setUpdatedAt($now);
            $trickRepository->save($trick, true);
            $this->addFlash(
                'notice',
                'Your trick has been created!'
            );

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    // READ ONE TRICK
    #[Route('/{id}', name: 'app_trick_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Trick $trick, CommentRepository $commentRepository): Response
    {
        //Paginator
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($trick, $offset);

        //Comment form
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (null === $this->getUser()) {
                $this->addFlash(
                    'notice', 
                    'You need to be logged in to write a comment'
                );

                return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
            }
            $user = $this->getUser();
            $comment->setAuthor($user)
                    ->setTrick($trick);
            $commentRepository->save($comment, true);
            $this->addFlash(
                'notice',
                'Your comment has been created'
            );

            return $this->redirectToRoute('app_trick_show', ['id' => $trick->getId()], Response::HTTP_SEE_OTHER);
        }

        //Render
        return $this->renderForm('trick/show.html.twig', [
            'trick' => $trick,
            'comment' => $comment,
            'form' => $form,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
        ]);
    }

    // UPDATE
    #[Route('/{id}/edit', name: 'app_trick_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $now = new DateTimeImmutable();
            $trick->setUpdatedAt($now);

            $trickRepository->save($trick, true);

            $this->addFlash(
                'notice',
                'Your trick has been updated!'
            );

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    // DELETE
    #[Route('/{id}/delete', name: 'app_trick_delete', methods: ['POST'])]
    public function delete(Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $trickRepository->remove($trick, true);
        }
        $this->addFlash(
            'notice',
            'Your trick has been deleted!'
        );

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
