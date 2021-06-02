<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\Equipe;
use App\Repository\PersonneRepository;
use App\Repository\EquipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/personnes/{id}", name="add_personne", methods={"POST"})
     */
    public function addPersonne(Equipe $equipe, Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent());
        $personne = new Personne();
        // hydrater
        $personne->setPrenom($data->prenom);
        $personne->setNom($data->nom);
        $personne->setEquipe($equipe);
        $em->persist($personne);
        $em->flush();
        $tab["id"] = $personne->getId();
        return $this->json($tab);
    }

    /**
     * @Route("/personnes/{id}", name="delete_personne", methods={"DELETE"})
     */
    public function removePersonne(Personne $personne, EntityManagerInterface $em): Response
    {
        $em->remove($personne);
        $em->flush();
        $tab["delete"] = "ok";
        return $this->json($tab);
    }

     /**
     * @Route("/personnes/{id}", name="update_personne", methods={"PUT"})
     */
  
    public function updatePersonne($id, Request $request, PersonneRepository $repo, EntityManagerInterface $em): Response
    {
        $personne = $repo->find($id);

        $data = json_decode($request->getContent());

        $personne->setPrenom($data->prenom);
        
       
        $em->persist($personne);
        $em->flush();

        $tab["id"] = $id;
        return $this->json($tab);
    }

    /**
     * @Route("/personnes/", name="list_personne", methods={"GET"})
     */
    public function allPersonne(PersonneRepository $repo): Response
    {
        return $this->json($repo->findAll());
    }

    /**
     * @Route("/equipes/", name="add_equipe", methods={"POST"})
     */
    public function addEquipe(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent());
        $equipe = new Equipe();
        // hydrater
        $equipe->setNom($data->nom);
        $em->persist($equipe);
        $em->flush();
        $tab["id"] = $equipe->getId();
        return $this->json($tab);
    }

    /**
     * @Route("/equipes/{id}", name="delete_equipe", methods={"DELETE"})
     */
    public function removeEquipe(Equipe $equipe, EntityManagerInterface $em): Response
    {
        $em->remove($equipe);
        $em->flush();
        $tab["delete"] = "ok";
        return $this->json($tab);
    }

     /**
     * @Route("/equipes/{id}", name="update_equipe", methods={"PUT"})
     */
  
    public function updateEquipe($id, Request $request, EquipeRepository $repo, EntityManagerInterface $em): Response
    {
        $equipe = $repo->find($id);

        $data = json_decode($request->getContent());

        $equipe->setNom($data->nom);
        
       
        $em->persist($equipe);
        $em->flush();

        $tab["id"] = $id;
        return $this->json($tab);
    }

    /**
     * @Route("/equipes/", name="list_equipe", methods={"GET"})
     */
    public function allEquipe(EquipeRepository $repo): Response
    {
        return $this->json($repo->findAll());
    }
}
