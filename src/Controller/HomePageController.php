<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(EntityManagerInterface $em)
    {
        $projects = $em->getRepository(Project::class)->findBy([], ['onTheTop' => 'DESC', 'publishedAt' => 'DESC'], 5);
        $contactForm = $this->createForm(ContactType::class);

        return $this->render('Home/home_page.html.twig', [
            'projects' => $projects,
            'contactForm' => $contactForm->createView(),
        ]);
    }
}
