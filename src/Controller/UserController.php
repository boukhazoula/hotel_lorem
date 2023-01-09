<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $userRepository->save($user,true);
            return $this->redirectToRoute('app_home');
        }

        return $this->render('user/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/resume-resa{id}', name: 'app_resume_resa')]
    public function resumResa($id, ReservationRepository $reservationRepository): Response
    {
        return $this->render('user/resum.html.twig',['reservation' => $reservationRepository->find($id)]);
    }
}
