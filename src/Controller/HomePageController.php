<?php

namespace App\Controller;

use App\DTO\ContactData;
use App\Entity\Project;
use App\Form\ContactType;
use App\Service\ContactMail;
use App\Service\MailSender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HomePageController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var MailSender
     */
    private $sender;

    /**
     * HomePageController constructor.
     * @param EntityManagerInterface $em
     * @param MailSender $sender
     */
    public function __construct(EntityManagerInterface $em, MailSender $sender)
    {
        $this->em     = $em;
        $this->sender = $sender;
    }

    /**
     * @Route("/", name="home_page")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, ValidatorInterface $validator)
    {
        $projects = $this->em->getRepository(Project::class)->findBy(
            [],
            ['onTheTop' => 'DESC', 'publishedAt' => 'DESC'],
            5
        );

        $contact = new ContactData();
        $contactForm = $this->createForm(ContactType::class, $contact)->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $errors = $validator->validate($contact);

            if (count($errors) > 0) {
                $this->addFlash('error', 'Une erreur est survenue');

                return $this->render('Home/home_page.html.twig', [
                    'projects' => $projects,
                    'contactForm' => $contactForm->createView(),
                ]);
            }

            $this->sendContactMail($contact);
            $this->addFlash('success', 'Merci pour votre message !');
        }

        return $this->render('Home/home_page.html.twig', [
            'projects' => $projects,
            'contactForm' => $contactForm->createView(),
        ]);
    }

    /**
     *
     * PRIVATE
     *
     */

    /**
     * @param ContactData $data
     */
    private function sendContactMail(ContactData $data)
    {
        $subject = 'Un nouveau message t\'a été envoyé depuis ton portfolio !';
        $template = 'Email/contact_mail.html.twig';
        $context = [
            'firstName' => $data->firstName,
            'lastName'  => $data->lastName,
            'email'     => $data->email,
            'message'   => $data->message,
        ];

        $mail = new ContactMail($subject, $template, $context);

        try {
            $this->sender->sendTemplatedEmail($mail);
        } catch(\Exception $e) {
            // Error
        }

    }
}
