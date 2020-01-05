<?php

namespace App\Controller;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/mes-projets", name="projects")
     */
    public function projects(EntityManagerInterface $em)
    {
        $projects = $em->getRepository(Project::class)->findAll();

        return $this->render('Project/projects.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/projet/{slug}", name="project")
     */
    public function project(Request $request, EntityManagerInterface $em)
    {
        $slug = $request->attributes->get('slug');
        $project = $em->getRepository(Project::class)->findOneBy(['slug' => $slug]);

        return $this->render('Project/project.html.twig', [
            'project' => $project,
        ]);
    }
}
