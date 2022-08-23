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

    #[Route("/{page?1}/{page_size?10}", name: "person.list")]
    public function index(ManagerRegistry $managerRegistry, $page, $page_size): Response
    {
        $repository = $managerRegistry->getRepository(Person::class);
        $nbPersons = $repository->count([]);
        $nbPages = ceil($nbPersons / $page_size);
        $persons = $repository->findBy([], [], $page_size, ($page - 1) * $page_size);

        return $this->render('person/index.html.twig', [
            'persons' => $persons,
            'isPaginated' => true,
            'nbPages' => $nbPages,
            'page' => $page,
            'page_size' => $page_size,
        ]);
    }

    #[Route("/{id<\d+>}", name: "person.show")]
    public function show(ManagerRegistry $managerRegistry, $id): Response
    {
        $repository = $managerRegistry->getRepository(Person::class);
        $person = $repository->find($id);
        if (!$person) {
            $this->addFlash("error", "The person with $id not existed!");
            return $this->redirectToRoute("person.list");
        }
        return $this->render('person/detail.html.twig', [
            'person' => $person,
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

    #[Route('/delete/{id<\d+>}', name: 'person.delete')]
    public function deletePerson() {

    }
}
