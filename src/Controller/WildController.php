<?php
// src/Controller/WildController.php
namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WildController extends AbstractController
{

    /**
     * Show all rows from Program’s entity
     *
     * @Route("/wild", name="wild_index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        if (!$programs) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }

        return $this->render(
            'wild/index.html.twig',
            ['programs' => $programs]
        );
    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("wild/show/{slug}", defaults={"slug" = null}, name="show")
     * @return Response
     */
    public function show(?string $slug):Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with '.$slug.' title, found in program\'s table.'
            );
        }

        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug'  => $slug,
        ]);
    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("wild/category/{slug}", defaults={"slug" = null}, name="show_category")
     * @return Response
     */
    public function showByCategory(?string $slug):Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a category in categories table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => mb_strtolower($slug)]);
        if (!$category) {
            throw $this->createNotFoundException(
                'No program with '.$slug.' title, found in categories table.'
            );
        }
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => $category->getId()],
                ['id' => 'desc'], 3, 0);

        return $this->render('wild/category.html.twig', [
            'category' => $category,
            'slug'  => $slug,
            'programs'=>$programs,
        ]);
    }

    /**
     * Getting a season with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("wild/program/{slug}", defaults={"slug" = null}, name="show_programd")
     * @return Response
     */
    public function showByProgram(?string $slug):Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a category in categories table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title'=>mb_strtolower($slug)]);
        if (!$programs) {
            throw $this->createNotFoundException('No program with ' . $slug . ' program, found in program\'s table.');
        }
        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findBy(['program'=> $programs->getId()], ['id' => 'asc'], 3, 0);

        return $this->render('wild/program.html.twig', [
            'slug'  => $slug,
            'programs'=>$programs,
            'seasons'=>$season,
        ]);
    }


    /**
     * Getting a season with a formatted slug for title
     *
     * @Route("wild/season/{id}", defaults={"id" = null}, name="show_season")
     * @param int|null $id
     * @return Response
     */
    public function showBySeason(?int $id):Response
    {
        if (!$id) {
            throw $this
                ->createNotFoundException('No result has been sent ');
        }

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->find($id);
        if (!$season) {
            throw $this->createNotFoundException('No program with ' . $id . ' program, found in program\'s table.');
        }

        return $this->render('wild/season.html.twig', [
            'programs'=>$season->getProgram(),
            'episodes'=>$season->getEpisodes(),
            'season'=>$season,
        ]);
    }

    /**
     * Getting episodes with an Id
     * @Route("wild/episode/{slug}", defaults={"slug"=null}, name="show_episode")
     * @param Episode $episode
     * @return Response A episode
     */
    public function showEpisode(Episode $episode): Response
    {
        if (!$episode) {
            throw $this->createNotFoundException('No id has been sent to find seasons in season\'s table');
        }
        $season = $episode->getSeason();
        $program = $season->getProgram();
        return $this->render('wild/episode.html.twig', [
            'episode' => $episode,
            'season' => $season,
            'program' => $program,
        ]);
    }



    /**
     * @Route("/wild/actor/{slug}", name="show_actor")
     * @param Actor $actor
     * @return Response
     */

    public function showActor(Actor $actor): Response
    {
        return $this->render('wild/actor.html.twig', [
                'actor' => $actor,
            ]
        );
    }
}
