<?php

namespace App\Controller;


use App\Repository\DbCandidatesRepository;
use App\Service\ExcelExportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Attribute\Route;

class ExcelController extends AbstractController
{
    private ExcelExportService $excelExportService;

    public function __construct(
        ExcelExportService $excelExportService
    )
    {
        $this->excelExportService = $excelExportService;
    }

    #[Route('/excel/export/all', name: 'app_excel_export_all')]
    public function exportAll(DbCandidatesRepository $repo): Response
    {
        $data = [$this->getData()];

        $students = $repo->findAll();

        $data = $this->getDataStudent($students, $data);

        $filePath = $this->excelExportService->exportToExcel($data, 'UTL-PREINSCRIPTION 2025-2026.xlsx', '2025-2026');

        $response = new StreamedResponse(function () use ($filePath) {
            readfile($filePath);
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="UTL-PREINSCRIPTION 2025-2026.xlsx"');
        $response->headers->set('Cache-Control', 'max-age=0');
        $response->headers->set('Cache-Control', 'max-age=1');

        return $response;
    }

    #[Route('/excel/export/register', name: 'app_excel_export_register')]
    public function exportRegister(DbCandidatesRepository $repo): Response
    {
        $data = [$this->getData()];

        $students = $repo->findBy(['isVerified' => true], ['id' => 'ASC']);

        $data = $this->getDataStudent($students, $data);

        $filePath = $this->excelExportService->exportToExcel($data, 'UTL-INSCRIPTION 2025-2026.xlsx', '2025-2026');

        $response = new StreamedResponse(function () use ($filePath) {
            readfile($filePath);
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="UTL-INSCRIPTION 2025-2026.xlsx"');
        $response->headers->set('Cache-Control', 'max-age=0');
        $response->headers->set('Cache-Control', 'max-age=1');

        return $response;
    }

    private function getData():array
    {
        return [
            'CODE', 'NOM', 'POST-NOM', 'PRENOM','NATIONALITE', 'E-MAIL', 'N°TELEPHONE', 'LIEU DE NAISSANCE', 'DATE DE NAISSANCE', 'SEXE', 'PROVINCE D\'ORIGINE', 'TERRITOIRE D\'ORIGINE', 'ETAT CIVIL', 'RESIDENCE', 'N°',
            'AVENUE', 'QUARTIER', 'COMMUNE', 'VILLE', 'FACULTE 1', 'FILIERE 1', 'FACULTE 2', 'FILIERE 2', 'ECOLE', 'SECTION', 'OPTION', 'ANNEE', 'POURCENTATGE', 'PAYS', 'CODE', 'PROVINCE',
            'TYPE DE DIPLOME', 'N° DU DIPLOME', 'DIPLOME DELIVRE A', 'DIPLOME DELIVRE LE',
            'NOM\'URGENCE', 'RELATION D\'URGENCE', 'N° TELEPHONE D\'URGENCE', 'E-MAIL D\'URGENCE', 'NOM DU PERE', 'PROFESSION DU PERE', 'N°TELEPHONE DU PERE', 'E-MAIL DU PERE',
            'NOM DE LA MERE', 'PROFESSION DE LA MERE', 'N°TELEPHONE DE LA MERE', 'E-MAIL DE LA MERE',
            'SPECIALE', 'PROVENANCE', 'FACULTE/FILIERE DE PROVENANCE', 'PROMOTION DEMANDER',
            'DATE DE PREINSCRIPTION', 'DATE DU BORDEREAU', 'REFERENCE BORDEREAU',
        ];
    }

    /**
     * @param array $students
     * @param array $data
     * @return array
     */
    private function getDataStudent(array $students, array $data): array
    {
        foreach ($students as $item) {
            $data[] = [
                $item->getCode(), $item->getName(), $item->getFistName(), $item->getLastName(), $item->getNationality(), $item->getEmail(), $item->getPhone(), $item->getPlaceBirth(), $item->getDateBirth(), $item->getSexe()->getName(), $item->getProvinceOrigin(), $item->getTerritoryOrigin(), $item->getMaritalStatus()->getName(), $item->getResidence()->getName(), $item->getAddNumber(),
                $item->getAddAvenue(), $item->getAddQuarter(), $item->getAddMunicipality(), $item->getAddCity(), $item->getFacOne()?->getName() ?? 'N\D', $item->getFistChoice()?->getName() ?? 'N\D', $item->getFactTwo()?->getName() ?? 'N\D', $item->getSecondChoice()?->getName() ?? 'N\D', $item->getScName(), $item->getScSection(), $item->getScOption(), $item->getScYear(), $item->getScPercentage(), $item->getScCountry(), $item->getScCode(), $item->getScProvince(),
                $item->getScDiplomaType(), $item->getScDiplomaNumber(), $item->getScDiplomaPlace(), $item->getScDiplomaDate(),
                $item->getUrgName(), $item->getUrgRelation(), $item->getUrgPhone(), $item->getUrgMail(), $item->getFatherName(), $item->getFatherOccupation(), $item->getFatherPhone(), $item->getFatherMail(),
                $item->getMotherName(), $item->getMotherOccupation(), $item->getMotherPhone(), $item->getMotherMail(),
                $item->isSpecial() ? 'Oui' : 'Non', $item->getInstOrigin(), $item->getFacultyOrigin(), $item->getPromRequest(),
                $item->getCreatedAt(), $item->getSlipAt(), $item->getSlipRef(),
            ];
        }
        return $data;
    }
}
