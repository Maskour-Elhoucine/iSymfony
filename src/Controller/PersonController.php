<?php

namespace App\Controller;

use App\Entity\Person;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/person")]
class PersonController extends AbstractController
{

    #[Route("/", name: "person.list")]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $repository = $managerRegistry->getRepository(Person::class);
        $persons = $repository->findAll();

        return $this->render('person/index.html.twig', [
            'persons' => $persons,
        ]);
    }

    #[Route('/add', name: 'person.add')]
    public function addPerson(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $person = new Person();
        $person->setName('MASKOUR Elhoucine');
        $person->setBirthday(new \DateTime('1996-07-01'));
        $person->setEmail('elhoucine.maskour7@gmail.com');
        $person->setPhone('+216 71 888 888');

        // add it, persist it
        $entityManager->persist($person);

        // excute the query
        $entityManager->flush();

        return $this->render('person/detail.html.twig', [
            'person' => $person,
        ]);
    }
}
