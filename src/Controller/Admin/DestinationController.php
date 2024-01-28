<?php

namespace App\Controller\Admin;

use App\Entity\Destination;
use App\Form\DestinationType;
use App\Repository\DestinationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/destination', name: 'admin_destination_')]
class DestinationController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    #[Route('/', name: 'index')]
    public function index(DestinationRepository $destinationRepository): Response
    {
        return $this->render('admin/destination/index.html.twig', [
            'destinations' => $destinationRepository->findAll(),
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request, #[Autowire('%images_dir%')] string $imagesDir): Response
    {
        $destination = new Destination();
        $destinationForm = $this->createForm(DestinationType::class, $destination);
        $destinationForm->handleRequest($request);
        if ($destinationForm->isSubmitted() && $destinationForm->isValid()) {
            if($image = $destinationForm['image']->getData()) {
                $filename = bin2hex(random_bytes(6)) . '.' . $image->guessExtension();
                $image->move($imagesDir, $filename);
                $destination->setImage($filename);
            }
            $this->entityManager->persist($destination);
            $this->entityManager->flush();
            return $this->redirectToRoute('admin_destination_index');
        }

        return $this->render('admin/destination/add.html.twig', [
            'destination_form' => $destinationForm,
        ]);
    }
}
