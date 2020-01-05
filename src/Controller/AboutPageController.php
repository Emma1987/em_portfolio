<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AboutPageController extends AbstractController
{
    /**
     * @Route("/a-propos", name="about_page")
     */
    public function about()
    {
        return $this->render('About/about_page.html.twig');
    }

    /**
     * @Route("/contact", name="contact_page")
     */
    public function contact()
    {
        return $this->render('About/contact_page.html.twig');
    }

    /**
     * @Route("/mentions-legales", name="mentions_page")
     */
    public function mentions()
    {
        return $this->render('About/mentions_page.html.twig');
    }
}
