<?php

namespace App\Controller\Admin;

use App\Entity\Destination;
use App\Repository\DestinationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/destination', name: 'admin_destination_')]
class DestinationController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(DestinationRepository $destinationRepository): Response
    {
        return $this->render('admin/destination/index.html.twig', [
            'destinations' => $destinationRepository->findAll(),
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(): Response
    {
        return $this->render('admin/destination/add.html.twig', [
            'form' => $form,
        ]);
    }
}
