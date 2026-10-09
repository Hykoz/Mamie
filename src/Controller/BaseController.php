<?php

namespace App\Controller;

use App\Form\AjoutCafeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Cafe;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;

final class BaseController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', [
        ]);
    }

    #[Route('/ajoutcafe', name: 'app_ajoutcafe')]
    public function ajoutcafe(Request $request, EntityManagerInterface $em): Response
    {
        $ajoutcafe = new Cafe();
        $form = $this->createForm(AjoutCafeType::class, $ajoutcafe);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($ajoutcafe);
                $em->flush();
                $this->addFlash('notice','Message envoyé');
                return $this->redirectToRoute('app_ajoutcafe');
            }
        }

        return $this->render('base/ajoutcafe.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
