<?php

namespace App\Controller;

use App\Entity\TypesConges;
use App\Form\TypesCongesType;
use App\Repository\TypesCongesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/types/conges')]
class TypesCongesController extends AbstractController
{
    #[Route('/', name: 'app_types_conges_index', methods: ['GET'])]
    public function index(TypesCongesRepository $typesCongesRepository): Response
    {
//        $this->addFlash('notice', 'deleted successfully');
        return $this->render('types_conges/index.html.twig', [
            'types_conges' => $typesCongesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_types_conges_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypesCongesRepository $typesCongesRepository): Response
    {
        $typesConge = new TypesConges();
        $form = $this->createForm(TypesCongesType::class, $typesConge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typesCongesRepository->save($typesConge, true);

            $this->addFlash('notice', 'submitted successfully');

//            return $this->redirectToRoute('app_types_conges_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('types_conges/new.html.twig', [
            'types_conge' => $typesConge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_types_conges_show', methods: ['GET'])]
    public function show(TypesConges $typesConge): Response
    {
        return $this->render('types_conges/show.html.twig', [
            'types_conge' => $typesConge,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_types_conges_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypesConges $typesConge, TypesCongesRepository $typesCongesRepository): Response
    {
        $form = $this->createForm(TypesCongesType::class, $typesConge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typesCongesRepository->save($typesConge, true);

            $this->addFlash('notice', 'Updated successfully');

//            return $this->redirectToRoute('app_types_conges_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('types_conges/edit.html.twig', [
            'types_conge' => $typesConge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_types_conges_delete', methods: ['POST'])]
    public function delete(Request $request, TypesConges $typesConge, TypesCongesRepository $typesCongesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typesConge->getId(), $request->request->get('_token'))) {
            $typesCongesRepository->remove($typesConge, true);
        }

        return $this->redirectToRoute('app_types_conges_index', [], Response::HTTP_SEE_OTHER);
    }
}
