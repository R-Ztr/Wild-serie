<?php
namespace App\Controller;

use App\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActorRepository;
use App\Form\ActorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/actor', name: 'actor_')]
class ActorController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ActorRepository $actorRepository): Response
    {
        $actor = $actorRepository->findAll();
        return $this->render('actor/index.html.twig', [ 
            'actor' => $actor,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Actor $actors): Response
    {
        if (!$actors) {
            throw $this->createNotFoundException(
                'No actor with id : '.$actors.' found in actor\'s table.'
            );
        }
        return $this->render('actor/show.html.twig', [
            'actors' => $actors,
        ]);

    }

    #[ROUTE('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($actor);
            $entityManager->flush();

            $this->addFlash('success', 'The new actor has been created');


            return $this->redirectToRoute('actor_index');
        }
        return $this->render('actor/new.html.twig', [
            'form' => $form
        ]);
    
    }

}