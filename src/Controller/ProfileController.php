<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Profile;
use App\Entity\User;
use App\Form\ProfileType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $profile_user = $entityManager->getRepository(Profile::class)->findBy(
            ['candidate' => $this->getUser()->getId()],
            ['id' => 'ASC']
        );

        return $this->render('profile/index.html.twig', [
            'profileUsers' => $profile_user,
        ]);
    }

    #[Route('/membre', name: 'membre')]
    public function membre(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {

            $profile = new Profile();
            $form = $this->createForm(ProfileType::class, $profile);
            $form->handleRequest($request);



            if ($form->isSubmitted() && $form->isValid()) {

          
                // $profile->setCreatedAt(new DateTime());

                $profile->setCandidate($this->getUser());
          
                $entityManager->persist($profile);
                $entityManager->flush();
          
                $this->addFlash('success', 'Profile correctement enregistrée !');
             }

            return $this->render('membre/membre.html.twig', [
                'form' => $form->createView()
              ]);
              
        }else {
            return $this->redirect('/login');
        }
    }

    #[Route('/membrepro', name: 'app_membrepro')]
    public function membrepro(EntityManagerInterface $entityManager): Response
    {

        if(!$this->getUser()->isProvider()){
            return $this->redirect('/');
        }


        $conn = $entityManager->getConnection();
        $sql = '
        SELECT *, sum(profile.years) as exp FROM user as p INNER JOIN profile ON p.id = profile.candidate_id 
        WHERE p.provider = 0
        GROUP BY p.id
        ORDER BY profile.id DESC
        ';

        $profile_user = $conn->executeQuery($sql, ['provider' => 0]);

        return $this->render('membre/membrepro.html.twig', [
            'profileUsers' => $profile_user->fetchAllAssociative(),
        ]);
    }

    #[Route('/profilepro/{id}', name: 'app_profilepro')]
    public function profilepro(EntityManagerInterface $entityManager, $id): Response
    {

        if(!$this->getUser()->isProvider()){
            return $this->redirect('/');
        }

        $profile_user = $entityManager->getRepository(Profile::class)->findBy(
            ['candidate' => $id],
            ['id' => 'ASC']
        );

        return $this->render('profile/profiledetail.html.twig', [
            'profileUsers' => $profile_user,
        ]);
    }
}
