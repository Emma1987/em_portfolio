<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Project;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProjectController
 * @package App\Controller
 */
class ProjectController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ProjectController constructor.
     * @param EntityManagerInterface $em
     *
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * List of all projects
     *
     * @Route("/mes-projets", name="projects")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function projects()
    {
        $projects = $this->em->getRepository(Project::class)->getProjectsWithCategories();
        $technologies = $this->em->getRepository(Category::class)->findBy(['filterable' => true]);

        $projectTechnologies = [];
        foreach ($projects as $project) {
            $projectTechnologies[$project->getId()] = $this->getTechnlogiesToString($project->getCategories());
        }

        return $this->render('Project/projects.html.twig', [
            'projects'     => $projects,
            'technologies' => $technologies,
            'projectTechnologies' => $projectTechnologies,
        ]);
    }

    /**
     * View of single project
     *
     * @Route("/projet/{slug}", name="project")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function project(Request $request)
    {
        $slug = $request->attributes->get('slug');
        $project = $this->em->getRepository(Project::class)->findOneBy(['slug' => $slug]);

        return $this->render('Project/project.html.twig', [
            'project' => $project,
        ]);
    }

    /**
     *
     * PRIVATE
     *
     */

    /**
     * @param Collection[Category] $technologies
     * @return array
     */
    public function getTechnlogiesToString(Collection $technologies): array
    {
        $array = [];

        foreach ($technologies as $technology) {
            $array[] = $technology->getName();
        }

        return $array;
    }
}
