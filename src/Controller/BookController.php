<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/book')]
final class BookController extends AbstractController
{
    #[Route(name: 'app_book_index', methods: ['GET'])]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    #[Route('/allbooks', name: 'app_book_get', methods: ['GET'])]
    public function getBooks(Request $request, BookRepository $repo): Response
    {
        $q = $request->query->get('q', '');
        $items = $repo->findBySearchTerm($q);

        // Verificar si la solicitud es de Turbo
        if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            // Renderizar solo la tabla como Turbo Stream
            return $this->render('book/searchTable.html.twig', [
                'books' => $items,
            ], new Response(null, 200, ['Content-Type' => TurboBundle::STREAM_MEDIA_TYPE]));
        }

        // Renderizar la página completa
        return $this->render('book/search.html.twig', [
            'books' => $items,
        ]);
    }

    /*#[Route('/search', name: 'app_book_search', methods: ['GET'])]
    public function searchBooks(Request $request, BookRepository $repo): Response
    {
        $q = $request->query->get('q', '');
        $items = $repo->findBySearchTerm($q);
        $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
        var_dump($items);
        return $this->redirectToRoute('app_book_get', ['books' => $items]);
    }*/


    #[Route('/new/{book?}', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ?Book $book, EntityManagerInterface $entityManager): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book, [
            'action' => $this->generateUrl('app_book_new', ['book' => $book?->getId()]),
        ]);
        $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($book);
                $entityManager->flush();

                return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', methods: ['GET'])]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookType::class, $book, [
            'action' => $this->generateUrl('app_book_edit', ['id' => $book?->getId()]),
        ]);
        $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
            }

        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_book_delete', methods: ['POST', 'GET'])]
    public function delete(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

        if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }


}
