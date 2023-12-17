<?php

namespace App\Controller;

use App\Entity\Program;
use App\Form\ProgramType;
use App\Repository\EpisodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Service\ProgramDuration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository, RequestStack $requestStack): Response
    {
        $programs = $programRepository->findAll();

        $session = $requestStack->getSession();

    if (!$session->has('total')) {
        $session->set('total', 0); 
    }

    $total = $session->get('total');
        
        return $this->render('program/index.html.twig', [
            'programs' => $programs,
            'session' => $session,
            'total' => $total,
         ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, MailerInterface $mailer, EntityManagerInterface $entityManager, SluggerInterface $slugger, ProgramRepository $programRepository) : Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);
            $entityManager->persist($program);
            $entityManager->flush();

           // $programRepository->save($program, true); 

            $email = (new Email())
            ->from($this->getParameter('mailer_from'))
            ->to('your_email@example.com')
            ->subject('Une nouvelle série vient d\'être publiée !')
            ->html($this->renderView('Program/newProgramEmail.html.twig', ['program' => $program]));
             $mailer->send($email);

    
            $this->addFlash('success', 'The new program has been created');

            return $this->redirectToRoute('program_index');
        }
    
        return $this->render('program/new.html.twig', [
            'form' => $form,
            'program' => $program,
        ]);
    }

    #[Route('/show/{slug}', name: 'show')]
    public function show(Program $program, ProgramDuration $programDuration):Response
    {
        //$program = $programRepository->findOneBy(['id' => $id]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$program.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'programDuration' => $programDuration->calculate()
        ]);
    }

    #[Route('/{slug}/season/{seasonId}', name: 'season_show')]
    public function showSeason(Program $program, int $seasonId,  SeasonRepository $seasonRepository)
    {
            //$program = $programRepository->find($programId);

            if (!$program) {
                throw $this->createNotFoundException(
                    'No program with id : '. $program->getId() .' found in program\'s table.'
                );
            }

            $season = $seasonRepository->find($seasonId);

            if (!$season) {
                throw $this->createNotFoundException(
                    'No program with id : '. $seasonId .' found in program\'s table.'
                );
            }

            
            return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season, 
        ]);
    }

    #[Route('program/{slug}/season/{seasonId}/episode/{episodeId}', name: 'episode_show')]
    public function showEpisode(
    //int $programId,
    Program $program,
    int $seasonId, 
    int $episodeId, 
    //ProgramRepository $programRepository,
    SeasonRepository $seasonRepository,
    EpisodeRepository $episodeRepository)
    {
        //$program = $programRepository->find($programId);
        $season = $seasonRepository->find($seasonId);
        $episode = $episodeRepository->find($episodeId);

        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
        ]);
    }


}