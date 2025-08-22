<?php

namespace App\Controller;

use App\Entity\DbCandidates;
use App\Form\CandidateFormType;
use App\Repository\DbCandidatesRepository;
use App\Repository\DbConditionsRepository;
use App\Repository\DbFacultiesRepository;
use App\Repository\DbSectorsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
class ApplicationController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, DbCandidatesRepository $repository, DbConditionsRepository $repo): Response
    {
        $candidate = new DbCandidates();
        $form = $this->createForm(CandidateFormType::class, $candidate);
        $form->handleRequest($request);

        $lastId = $repository->count();

        if ($form->isSubmitted() && $form->isValid()) {

            $now = new \DateTimeImmutable('now', new \DateTimeZone('Africa/Lubumbashi') );
            $year = $now->format('y');
            $mount = $now->format('m');
            $num = $year . $mount . str_pad($lastId + 1, 5, 0, STR_PAD_LEFT);
            $candidate
                ->setIsSpecial(true)
                ->setName(strtoupper($candidate->getName()))
                ->setFistName(strtoupper($candidate->getFistName()))
                ->setLastName(strtoupper($candidate->getLastName()))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCode($num)
                ->setVerified(false);

            $entityManager->persist($candidate);
            $entityManager->flush();

            return $this->redirectToRoute('app_application_show', ['code' => $candidate->getCode()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('application/new.html.twig', [
            'conditions' => $repo->find(1),
            'st_pre_registration' => $candidate,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/speciale', name: 'app_application_news_special', methods: ['GET', 'POST'])]
    public function newSpecial(Request $request, EntityManagerInterface $entityManager, DbCandidatesRepository $repository, DbConditionsRepository $repo): Response
    {
        $candidate = new DbCandidates();
        $form = $this->createForm(CandidateFormType::class, $candidate);
        $form->handleRequest($request);

        $lastId = $repository->count();

        if ($form->isSubmitted() && $form->isValid()) {

            $now = new \DateTimeImmutable('now', new \DateTimeZone('Africa/Lubumbashi') );
            $year = $now->format('y');
            $mount = $now->format('m');
            $num = $year . $mount . str_pad($lastId + 1, 5, 0, STR_PAD_LEFT);
            $candidate
                ->setIsSpecial(true)
                ->setName(strtoupper($candidate->getName()))
                ->setFistName(strtoupper($candidate->getFistName()))
                ->setLastName(strtoupper($candidate->getLastName()))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCode($num)
                ->setVerified(false);

            $entityManager->persist($candidate);
            $entityManager->flush();

            return $this->redirectToRoute('app_application_show', ['code' => $candidate->getCode()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('application/new.html.twig', [
            'conditions' => $repo->find(2),
            'st_pre_registration' => $candidate,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/search/{page<\d+>?1}', name: 'app_application_search', methods: ['GET'])]
    public function search(PaginatorInterface $paginator, $page, Request $request, DbCandidatesRepository $repo): Response
    {
        $query = $request->query->get('q');

        //dd($query);
        $data = $paginator->paginate(
            $repo->findBySearch($query),
            $request->query->getInt('page', $page),
            10
        );

        return $this->render('application/search.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/{code}', name: 'app_application_show', methods: ['GET'])]
    public function show(DbCandidates $candidate): Response
    {
        return $this->render('application/show.html.twig', [
            'candidate' => $candidate,
        ]);
    }

    #[Route('/verified/{code}', name: 'app_application_verified', methods: ['GET'])]
    public function verified(DbCandidates $candidate): Response
    {
        return $this->render('application/verified.html.twig', [
            'candidate' => $candidate,
        ]);
    }

    #[Route('/edit/{code}', name: 'app_application_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DbCandidates $candidates, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CandidateFormType::class, $candidates);
        $form->handleRequest($request);

        if ($candidates->isVerified()){
            return $this->redirectToRoute('app_application_show', ['code' => $candidates->getCode()], Response::HTTP_SEE_OTHER);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $candidates->setFacOne($candidates->getFistChoice()->getFaculty())
                        ->setFactTwo($candidates->getSecondChoice()->getFaculty());
            $entityManager->flush();
            return $this->redirectToRoute('app_application_show', ['code' => $candidates->getCode()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('application/new.html.twig', [
            'st_pre_registration' => $candidates,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_application_delete', methods: ['POST'])]
    public function delete(Request $request, DbCandidates $candidates, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidates->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($candidates);
            $entityManager->flush();
        }

        //return $this->redirectToRoute('app_application_index', [], Response::HTTP_SEE_OTHER);
        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/sectors/{id}', name:'app_application_sector', methods:["GET"])]
    public function sector(int $id, DbSectorsRepository $sectorsRepository, DbFacultiesRepository $facultiesRepository): JsonResponse
    {
        $faculty = $facultiesRepository->find($id);
        $sectors = $sectorsRepository->findBy(['faculty' => $faculty]);
        $data = [];

        foreach ($sectors as $item) {
            $data[] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
            ];
        }

        return new JsonResponse(['data' => $data]);
    }
}
