<?php

namespace App\Controller;

use App\Entity\DbSectors;
use App\Entity\DbCandidates;
use App\Repository\DbSectorsRepository;
use App\Repository\DbCandidatesRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use SecIT\SimpleExcelExport\Excel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PdfGeneratorController extends AbstractController
{
    #[Route('/fiche/{code}', name: 'app_pdf_generator', methods: ['GET'])]
    public function pdf(DbCandidates $stPreRegistrations, BuilderInterface $customQrCodeBuilder, Request $request): Response
    {
        $qr = $customQrCodeBuilder
            ->size(400)
            ->data($this->generateUrl('app_application_verified', ['code' => $stPreRegistrations->getCode()], UrlGeneratorInterface::ABSOLUTE_URL))
            ->margin(20)
            ->build();

        $path = $this->getParameter('kernel.project_dir');
        $html =  $this->renderView('pdf_generator/index.html.twig',
            [
                'data' => $stPreRegistrations,
                'logo' => $this->imageToBase64( $path . '/public/assets/img/favicon.png'),
                'qr' => $qr,
            ]);
        $url = $request->getSchemeAndHttpHost();
        $tmp = $url . '/public/assets/fonts/';
        $options = new Options();
        $options->setIsRemoteEnabled(true)
            ->setDefaultMediaType('all')
            ->setDefaultFont('sans-serif')
            ->setChroot($tmp);

        $dompdf = new Dompdf($options);
        $dompdf->setPaper('A4');
        $dompdf->loadHtml($html);
        $dompdf->render();

        $pdfOutput = $dompdf->output();
        $response = new Response($pdfOutput);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="Université Technologique du Lualaba - Fiche de Préinscription"');
        return $response;
    }


    #[Route('/pdf/down', name: 'app_pdf_generator_down', methods: ['GET'])]
    #[IsGranted('ROLE_PRIME')]
    public function down(DbCandidatesRepository $repo): Response
    {
        $html =  $this->renderView('pdf_generator/utl.html.twig',
            [
                'data' => $repo->findAll(),
            ]);
        $dompdf = new Dompdf();
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->loadHtml($html);
        $dompdf->render();

        return new Response (
            $dompdf->stream('utlRegister', ['compress' => true, "Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    #[Route('/global/schooling/{code}', name: 'app_pdf_down_fiche_solarize', methods: ['GET'])]
    #[IsGranted('ROLE_PRIME')]
    public function downFiche(DbCandidates $stPreRegistrations, BuilderInterface $customQrCodeBuilder, Request $request): Response
    {
        $qr = $customQrCodeBuilder
            ->size(400)
            ->data($this->generateUrl('app_application_verified', ['code' => $stPreRegistrations->getCode()], UrlGeneratorInterface::ABSOLUTE_URL))
            ->margin(20)
            ->build();

        $path = $this->getParameter('kernel.project_dir');
        $html =  $this->renderView('pdf_generator/fiche.html.twig',
            [
                'data' => $stPreRegistrations,
                'logo' => $this->imageToBase64( $path . '/public/assets/img/logo-fiche.png'),
                'qr' => $qr,
            ]);
        $url = $request->getSchemeAndHttpHost();
        $tmp = $url . '/public/assets/fonts/';
        $options = new Options();
        $options->setIsRemoteEnabled(true)
            ->setDefaultMediaType('all')
            ->setDefaultFont('sans-serif')
            ->setChroot($tmp);

        $dompdf = new Dompdf($options);
        $dompdf->setPaper('A4');
        $dompdf->loadHtml($html);
        $dompdf->render();

        $pdfOutput = $dompdf->output();
        $response = new Response($pdfOutput);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="Université Technologique du Lualaba - Fiche de Scolarité"');
        return $response;
    }


    public function ss(Array $tab, $req): Array|null
    {
        foreach ($tab as $item){
            if(in_array($req, $item)){
                return $item;
            }
        }
        return null;
    }

    private function imageToBase64($path) {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }

    /*
    #[Route('/fiches/export', name: 'app_pdf_export', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function excel(DbCandidatesRepository $repo): void
    {
        $data = $repo->findAll();
        $tab = [];
        foreach ($data as $item){
            $tab[] = $item;
        }
        $tabb = ['INSCRIPTION 2024-2025'
                => $tab,
        ];
        $excel = new Excel('UTL INSCRIPTION', Excel::OUTPUT_XLS);
        $excel->setColumnsAutoSizingEnabled(true);

        $excel->addSheet('INSCRIPTION 2024-2025')
            ->setColumn('CODE', 'code')
            ->setColumn('PAIEMENT', 'verified')
            ->setColumn('NOM', 'name')
            ->setColumn('POST-NOM', 'fistName')
            ->setColumn('PRENOM', 'lastName')
            ->setColumn('NATIONALITE', 'nationality')
            ->setColumn('E-MAIL', 'email')
            ->setColumn('N°TELEPHONE', 'phone')
            ->setColumn('LIEU DE NAISSANCE', 'placeBirth')
            ->setColumn('DATE DE NAISSANCE', 'dateBirth')
            ->setColumn('SEXE', 'sexe.name')
            ->setColumn('ETAT CIVIL', 'maritalstatus.name')
            ->setColumn('RESIDENCE', 'residence.name')
            ->setColumn('N°', 'addNumber')
            ->setColumn('AVENUE', 'addAvenue')
            ->setColumn('QUARTIER', 'addQuarter')
            ->setColumn('COMMUNE', 'addMunicipality')
            ->setColumn('VILLE', 'addCity')
            ->setColumn('PREMIER CHOIX', 'fistChoice.name')
            ->setColumn('DEUXIEME CHOIX', 'secondChoice.name')
            ->setColumn('ECOLE', 'scName')
            ->setColumn('SECTION', 'scSection')
            ->setColumn('ANNEE', 'scYear')
            ->setColumn('POURCENTAGE', 'scPercentage')
            ->setColumn('PAYS', 'scCountry')
            ->setColumn('NOM D\'URGENCE', 'urgName')
            ->setColumn('RELATION D\'URGENCE', 'urgRelation')
            ->setColumn('N°TELEPHONE D\'URGENCE', 'UrgPhone')
            ->setColumn('E-MAIL D\'URGENCE', 'urgMail')
            ->setColumn('NOM DU PERE', 'fatherName')
            ->setColumn('PROFESSION DU PERE', 'fatherOccupation')
            ->setColumn('N°TELEPHONE DU PERE', 'fatherPhone')
            ->setColumn('E-MAIL DU PERE', 'fatherMail')
            ->setColumn('NOM DE LA MERE', 'motherName')
            ->setColumn('PROFESSION DE LA MERE', 'motherOccupation')
            ->setColumn('N°TELEPHONE DE LA MERE', 'motherPhone')
            ->setColumn('E-MAIL DE LA MERE', 'motherMail')
            ->setColumn('DATE D\'INSCRIPTION', 'createdAt')
            ;

        $response = $excel->getResponse($tabb);
        $response->send();
    }

    #[Route('/fiches/export/pay', name: 'app_pdf_export_pay', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function pay(DbCandidatesRepository $repo, DbSectorsRepository $sectorsRepository): void
    {
        $sectors = $sectorsRepository->findAll();
        $excel = new Excel('UTL INSCRIPTION 2024-2025', Excel::OUTPUT_XLS);
        $excel->setColumnsAutoSizingEnabled(true);

        $sheet = [];
        foreach ($sectors as $tmp){
            $data = $repo->findBy(['fistChoice' => $tmp, 'isVerified' => true]);
            $tab = [];
            foreach ($data as $item){
                $tab[] = $item;
            }
            $sheet[substr(strtoupper($tmp->getName()),0,30)] = $tab;

            $excel->addSheet(substr(strtoupper($tmp->getName()),0,30))
                ->setColumn('CODE', 'code')
                ->setColumn('PAIEMENT', 'verified')
                ->setColumn('NOM', 'name')
                ->setColumn('POST-NOM', 'fistName')
                ->setColumn('PRENOM', 'lastName')
                ->setColumn('NATIONALITE', 'nationality')
                ->setColumn('E-MAIL', 'email')
                ->setColumn('N°TELEPHONE', 'phone')
                ->setColumn('LIEU DE NAISSANCE', 'placeBirth')
                ->setColumn('DATE DE NAISSANCE', 'dateBirth')
                ->setColumn('SEXE', 'sexe.name')
                ->setColumn('ETAT CIVIL', 'maritalstatus.name')
                ->setColumn('RESIDENCE', 'residence.name')
                ->setColumn('N°', 'addNumber')
                ->setColumn('AVENUE', 'addAvenue')
                ->setColumn('QUARTIER', 'addQuarter')
                ->setColumn('COMMUNE', 'addMunicipality')
                ->setColumn('VILLE', 'addCity')
                ->setColumn('PREMIER CHOIX', 'fistChoice.name')
                ->setColumn('DEUXIEME CHOIX', 'secondChoice.name')
                ->setColumn('ECOLE', 'scName')
                ->setColumn('SECTION', 'scSection')
                ->setColumn('ANNEE', 'scYear')
                ->setColumn('POURCENTAGE', 'scPercentage')
                ->setColumn('PAYS', 'scCountry')
                ->setColumn('NOM D\'URGENCE', 'urgName')
                ->setColumn('RELATION D\'URGENCE', 'urgRelation')
                ->setColumn('N°TELEPHONE D\'URGENCE', 'UrgPhone')
                ->setColumn('E-MAIL D\'URGENCE', 'urgMail')
                ->setColumn('NOM DU PERE', 'fatherName')
                ->setColumn('PROFESSION DU PERE', 'fatherOccupation')
                ->setColumn('N°TELEPHONE DU PERE', 'fatherPhone')
                ->setColumn('E-MAIL DU PERE', 'fatherMail')
                ->setColumn('NOM DE LA MERE', 'motherName')
                ->setColumn('PROFESSION DE LA MERE', 'motherOccupation')
                ->setColumn('N°TELEPHONE DE LA MERE', 'motherPhone')
                ->setColumn('E-MAIL DE LA MERE', 'motherMail')
                ->setColumn('DATE D\'INSCRIPTION', 'createdAt')
            ;
        }

        $response = $excel->getResponse($sheet);
        $response->send();
    }

    #[Route('/fiches/export/all', name: 'app_pdf_export_all', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function susAll(DbCandidatesRepository $repo, DbSectorsRepository $sectorsRepository): void
    {
        $sectors = $sectorsRepository->findAll();
        $excel = new Excel('UTL INSCRIPTION ALL 2024-2025', Excel::OUTPUT_XLS);
        $excel->setColumnsAutoSizingEnabled(true);

        $sheet = [];
        foreach ($sectors as $tmp){
            $data = $repo->findBy(['fistChoice' => $tmp]);
            $tab = [];
            foreach ($data as $item){
                $tab[] = $item;
            }
            $sheet[substr(strtoupper($tmp->getName()),0,30)] = $tab;

            $excel->addSheet(substr(strtoupper($tmp->getName()),0,30))
                ->setColumn('CODE', 'code')
                ->setColumn('PAIEMENT', 'verified')
                ->setColumn('NOM', 'name')
                ->setColumn('POST-NOM', 'fistName')
                ->setColumn('PRENOM', 'lastName')
                ->setColumn('NATIONALITE', 'nationality')
                ->setColumn('E-MAIL', 'email')
                ->setColumn('N°TELEPHONE', 'phone')
                ->setColumn('LIEU DE NAISSANCE', 'placeBirth')
                ->setColumn('DATE DE NAISSANCE', 'dateBirth')
                ->setColumn('SEXE', 'sexe.name')
                ->setColumn('ETAT CIVIL', 'maritalstatus.name')
                ->setColumn('RESIDENCE', 'residence.name')
                ->setColumn('N°', 'addNumber')
                ->setColumn('AVENUE', 'addAvenue')
                ->setColumn('QUARTIER', 'addQuarter')
                ->setColumn('COMMUNE', 'addMunicipality')
                ->setColumn('VILLE', 'addCity')
                ->setColumn('PREMIER CHOIX', 'fistChoice.name')
                ->setColumn('DEUXIEME CHOIX', 'secondChoice.name')
                ->setColumn('ECOLE', 'scName')
                ->setColumn('SECTION', 'scSection')
                ->setColumn('ANNEE', 'scYear')
                ->setColumn('POURCENTAGE', 'scPercentage')
                ->setColumn('PAYS', 'scCountry')
                ->setColumn('NOM D\'URGENCE', 'urgName')
                ->setColumn('RELATION D\'URGENCE', 'urgRelation')
                ->setColumn('N°TELEPHONE D\'URGENCE', 'UrgPhone')
                ->setColumn('E-MAIL D\'URGENCE', 'urgMail')
                ->setColumn('NOM DU PERE', 'fatherName')
                ->setColumn('PROFESSION DU PERE', 'fatherOccupation')
                ->setColumn('N°TELEPHONE DU PERE', 'fatherPhone')
                ->setColumn('E-MAIL DU PERE', 'fatherMail')
                ->setColumn('NOM DE LA MERE', 'motherName')
                ->setColumn('PROFESSION DE LA MERE', 'motherOccupation')
                ->setColumn('N°TELEPHONE DE LA MERE', 'motherPhone')
                ->setColumn('E-MAIL DE LA MERE', 'motherMail')
                ->setColumn('DATE D\'INSCRIPTION', 'createdAt')
            ;
        }

        $response = $excel->getResponse($sheet);
        $response->send();
    }
    */
}
