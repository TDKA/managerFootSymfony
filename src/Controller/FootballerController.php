<?php

namespace App\Controller;

use App\Entity\Footballer;
use App\Repository\FootballerRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/footapi")
 * 
 */
class FootballerController extends AbstractController
{
    /**
     * @Route("/", name="footballer", methods={"GET"})
     */
    public function index(FootballerRepository $repo): Response
    {
        $footballers = $repo->findAll();

        return $this->json($footballers, 200);
    }
    /**
     * 
     * @Route("/delete/{id}", name="deletePlayer", methods={"DELETE"})
     */
    public function delete(Footballer $footballer, EntityManagerInterface $manager)
    {

        $manager->remove($footballer);
        $manager->flush();

        return $this->json("Delete was successfull", 200);
    }
    /**
     * 
     * @Route("/create", name="createPlayer", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $manager, SerializerInterface $serializer)
    {
        $data = $request->getContent();

        $footballer = $serializer->deserialize($data, Footballer::class, 'json');

        $manager->persist($footballer);
        $manager->flush();

        return $this->json($footballer, 201);
    }
}
