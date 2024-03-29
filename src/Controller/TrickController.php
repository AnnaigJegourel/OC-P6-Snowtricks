<?php

namespace App\Controller;

use App\Entity\Trick;
use DateTimeImmutable;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Service\FileUploader;
use App\Repository\TrickRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/trick')]
class TrickController extends AbstractController
{
    // CREATE
    #[Route('/new', name: 'app_trick_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TrickRepository $trickRepository, SluggerInterface $slugger, FileUploader $fileUploader): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $now = new DateTimeImmutable();
            $trick->setUpdatedAt($now);
            $trick->setSlug($slugger->slug($trick->getName()));

            // Upload main image file 
            /** @var UploadedFile $mainImageFile */
            $mainImageFile = $form->get('mainImageFile')->getData();
            if ($mainImageFile) {
                $mainImageName = $fileUploader->upload($mainImageFile);
                $trick->setMainImageName($mainImageName);
            }

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
    #[Route('/{slug}', name: 'app_trick_show', methods: ['GET', 'POST'])]
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

            return $this->redirectToRoute('app_trick_show', ['slug' => $trick->getSlug()], Response::HTTP_SEE_OTHER);
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
    #[Route('/{slug}/edit', name: 'app_trick_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trick $trick, TrickRepository $trickRepository, SluggerInterface $slugger, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $now = new DateTimeImmutable();
            $trick->setUpdatedAt($now);

            //  Upload main image file 
            /** @var UploadedFile $mainImageFile */
            $mainImageFile = $form->get('mainImageFile')->getData();
            if ($mainImageFile) {
                $mainImageName = $fileUploader->upload($mainImageFile);
                $trick->setMainImageName(
                    $mainImageName
                );
            }
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
    #[Route('/{slug}/delete', name: 'app_trick_delete', methods: ['POST'])]
    public function delete(Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trick->getSlug(), $request->request->get('_token'))) {
                $trickRepository->remove($trick, true);
        }
        $this->addFlash(
            'notice',
            'Your trick has been deleted!'
        );

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }

    // REMOVE MAIN IMAGE
    #[Route('/{slug}/remove_main_image', name: 'app_trick_remove_main_image', methods: ['GET'])]
    public function removeMainImage(Trick $trick, FileUploader $fileUploader, EntityManagerInterface $entityManager): Response
    {
        $fileUploader->remove($trick->getMainImageName());
        $trick->setMainImageName(null);

        $entityManager->persist($trick);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'The main image has been removed.'
        );

        return $this->redirectToRoute('app_trick_edit', ['slug' => $trick->getSlug()], Response::HTTP_SEE_OTHER);
    }    
}
