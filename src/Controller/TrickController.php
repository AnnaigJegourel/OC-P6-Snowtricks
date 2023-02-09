<?php

namespace App\Controller;

use App\Entity\Trick;
// use DateTimeImmutable;
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

    #[Route('/{id}', name: 'app_trick_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Trick $trick, CommentRepository $commentRepository): Response
    {
        //use paginator
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($trick, $offset);

        //create comment form
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        // dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            // SI PAS CONNECTé
            if (null === $this->getUser()) {
                $this->addFlash('notice', 'You need to be logged in to write a comment');

                return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
            }
            //TENTATIVE 2:
            $user = $this->getUser();
            $comment->setAuthor($user)
                    ->setTrick($trick);
            //TENTATIVE 1:
            // $now = new DateTimeImmutable();
            // $comment->setTrick($trick)
            //         ->setCreatedAt($now)
            //         ->setAuthor($this->getUser())
            //         ;
            $commentRepository->save($comment, true);
            $this->addFlash(
                'notice',
                "Your comment has been created"
            );

            return $this->redirectToRoute('app_trick_show', ['id' => $trick->getId()], Response::HTTP_SEE_OTHER);
        }
// dd($commentRepository->findAll()); = array
        return $this->renderForm('trick/show.html.twig', [
            'trick' => $trick,
            'comment' => $comment,
            'form' => $form,
            // 'comments' => $commentRepository->findAll(),
            // 'comments' => $commentRepository->findByTrick($trick),
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
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
