<?php

namespace App\Controller;

use App\Entity\LeaveResquest;
use App\Form\LeaveResquestType;
use App\Repository\LeaveResquestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/leave/resquest')]
class LeaveResquestController extends AbstractController
{
    #[Route('/', name: 'app_leave_resquest_pending', methods: ['GET'])]
    public function index(LeaveResquestRepository $leaveResquestRepository): Response
    {
        return $this->render('leave_resquest/index.html.twig', [
            'leave_resquests' => $leaveResquestRepository->findByState(LeaveResquest::PENDING),
        ]);
    }

    #[Route('/approved', name: 'app_leave_resquest_approved', methods: ['GET'])]
    public function approved(LeaveResquestRepository $leaveResquestRepository): Response
    {
        return $this->render('leave_resquest/approved.html.twig', [
            'leave_resquests' => $leaveResquestRepository->findByState(LeaveResquest::APPROVED),
        ]);
    }

    #[Route('/refused', name: 'app_leave_resquest_refused', methods: ['GET'])]
    public function refused(LeaveResquestRepository $leaveResquestRepository): Response
    {
        return $this->render('leave_resquest/refused.html.twig', [
            'leave_resquests' => $leaveResquestRepository->findByState(LeaveResquest::REFUSED),
        ]);
    }

    #[Route('/new', name: 'app_leave_resquest_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LeaveResquestRepository $leaveResquestRepository): Response
    {
        $leaveResquest = new LeaveResquest();
        $form = $this->createForm(LeaveResquestType::class, $leaveResquest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//           $leaveResquest->setType($form->get('type')->getData());
            $leaveResquest->setUser($this->getUser());
            $leaveResquestRepository->save($leaveResquest, true);

            return $this->redirectToRoute('app_leave_resquest_pending', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('leave_resquest/new.html.twig', [
            'leave_resquest' => $leaveResquest,
            'Leaverequest' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_leave_resquest_show', methods: ['GET'])]
    public function show(LeaveResquest $leaveResquest): Response
    {
        return $this->render('leave_resquest/show.html.twig', [
            'leave_resquest' => $leaveResquest,
        ]);
    }

    #[Route('/{id}/changeState/{action}', name: 'app_leave_resquest_changeState', methods: ['GET'])]
    public function changeState(LeaveResquest $leaveResquest, string $action, LeaveResquestRepository $leaveResquestRepository): Response
    {
        if ($action == "refuse") {
            $leaveResquest->setState(LeaveResquest::REFUSED);
        } else {
            $leaveResquest->setState(LeaveResquest::APPROVED);
        }
        $leaveResquestRepository->save($leaveResquest, true);
        return $this->redirectToRoute("app_leave_resquest_pending");
    }

    #[Route('/{id}/edit', name: 'app_leave_resquest_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LeaveResquest $leaveResquest, LeaveResquestRepository $leaveResquestRepository): Response
    {
        $form = $this->createForm(LeaveResquestType::class, $leaveResquest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $leaveResquest->setUser($this->getUser());
            $leaveResquestRepository->save($leaveResquest, true);

            return $this->redirectToRoute('app_leave_resquest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('leave_resquest/edit.html.twig', [
            'leave_resquest' => $leaveResquest,
            'Leaverequest' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_leave_resquest_delete', methods: ['POST'])]
    public function delete(Request $request, LeaveResquest $leaveResquest, LeaveResquestRepository $leaveResquestRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $leaveResquest->getId(), $request->request->get('_token'))) {
            $leaveResquestRepository->remove($leaveResquest, true);
        }

        return $this->redirectToRoute('app_leave_resquest_index', [], Response::HTTP_SEE_OTHER);
    }
}
