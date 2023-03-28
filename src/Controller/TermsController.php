<?php

namespace App\Controller;

use App\Entity\Terms;
use App\Form\TermsType;
use App\Repository\TermsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/terms')]
class TermsController extends AbstractController
{
    #[Route('/', name: 'app_terms_index', methods: ['GET'])]
    public function index(TermsRepository $termsRepository): Response
    {
        return $this->render('terms/index.html.twig', [
            'terms' => $termsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_terms_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TermsRepository $termsRepository): Response
    {
        $term = new Terms();
        $form = $this->createForm(TermsType::class, $term);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $termsRepository->save($term, true);

            return $this->redirectToRoute('app_terms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('terms/new.html.twig', [
            'term' => $term,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_terms_show', methods: ['GET'])]
    public function show(Terms $term): Response
    {
        return $this->render('terms/show.html.twig', [
            'term' => $term,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_terms_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Terms $term, TermsRepository $termsRepository): Response
    {
        $form = $this->createForm(TermsType::class, $term);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $termsRepository->save($term, true);

            return $this->redirectToRoute('app_terms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('terms/edit.html.twig', [
            'term' => $term,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_terms_delete', methods: ['POST'])]
    public function delete(Request $request, Terms $term, TermsRepository $termsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$term->getId(), $request->request->get('_token'))) {
            $termsRepository->remove($term, true);
        }

        return $this->redirectToRoute('app_terms_index', [], Response::HTTP_SEE_OTHER);
    }
}
