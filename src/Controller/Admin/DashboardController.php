<?php

namespace App\Controller\Admin;

use App\Entity\DbApiKeys;
use App\Entity\DbConditions;
use App\Entity\DbCarousels;
use App\Entity\DbFaculties;
use App\Entity\DbMaritalStatus;
use App\Entity\DbSectors;
use App\Entity\DbSexes;
use App\Entity\DbUsers;
use App\Entity\StPayments;
use App\Entity\DbCandidates;
use App\Entity\DbResidences;
use App\Entity\UserLogs;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class DashboardController extends AbstractDashboardController
{
    private $manager;
    private ChartBuilderInterface $chartBuilder;
    private $sector ;
    private $faculty ;
    private $student ;

    public function __construct(EntityManagerInterface $manager, ChartBuilderInterface $cBuilder)
    {
        $this->manager = $manager;
        $this->chartBuilder = $cBuilder;
        $this->sector = $this->manager->getRepository(DbSectors::class);
        $this->student = $this->manager->getRepository(DbCandidates::class);
        $this->faculty = $this->manager->getRepository(DbFaculties::class);
    }

    #[Route('/global', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        //$adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        //return $this->redirect($adminUrlGenerator->setController(DbCarouselsCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');

        return $this->render('admin/index.html.twig', [
            'chartOne' => $this->chartOne(),
            'chartTwo' => $this->chartTwo(),
            'chartConfirmOne' => $this->chartConfirmOne(),
            'chartConfirmTwo' => $this->chartConfirmTwo(),
            'confirm' => $this->student->count(['isVerified' => true]),
            'pre' => $this->student->count(),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img class="img-fluid d-print-none" src="/assets/img/logo.png" alt="">')
            ->setFaviconPath('/assets/img/favicon.png')
            ;
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()->addWebpackEncoreEntry('admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Conditions', 'fas fa-file', DbConditions::class)->setPermission('ROLE_ROOT');
        yield MenuItem::subMenu('Applications', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Liste', 'fas fa-list', DbCandidates::class)->setPermission('ROLE_ROOT'),
            MenuItem::linktoRoute('Les candidats', 'fa fa-download', 'app_excel_export_all')->setPermission('ROLE_ADMIN'),
            MenuItem::linktoRoute('Les confirmations', 'fa fa-download', 'app_excel_export_register')->setPermission('ROLE_ADMIN'),
            MenuItem::linktoRoute('Télécharger Pdf', 'fa fa-download', 'app_pdf_generator_down'),
        ]);
        yield MenuItem::linkToCrud('Clés api', 'fas fa-key', DbApiKeys::class)->setPermission('ROLE_ROOT');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', DbUsers::class)->setPermission('ROLE_ROOT');
        yield MenuItem::subMenu('Configuration', 'fas fa-gear')->setSubItems([
            MenuItem::linkToCrud('Etat civil', 'fas fa-list', DbMaritalStatus::class),
            MenuItem::linkToCrud('Facultés', 'fas fa-list', DbFaculties::class),
            MenuItem::linkToCrud('Fillières', 'fas fa-list', DbSectors::class),
            MenuItem::linkToCrud('Sexe', 'fas fa-list', DbSexes::class),
            MenuItem::linkToCrud('Residences', 'fas fa-list', DbResidences::class),
        ])->setPermission('ROLE_ROOT');
        yield MenuItem::linkToCrud('Journaux utilisateurs', 'fas fa-book', UserLogs::class)
            ->setPermission('ROLE_ROOT')
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setCssClass('text-danger');
    }

    public function chartOne(): Chart
    {
        $tmp = $this->faculty->findAll();
        $labels = [];
        $data = [];
        $datas = [];

        foreach ($tmp as $tab) {
            $labels[] = $tab->getName();
            $data[] = count($this->student->findBy(['facOne' => $tab]));
            $datas[] = count($this->student->findBy(['factTwo' => $tab]));
        }

        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);

        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Premier choix',
                    'backgroundColor' => 'rgb(249,209,16)',
                    'borderColor' => 'rgb(249,209,16)',
                    'data' => $data,
                ],
                [
                    'label' => 'Deuxième choix',
                    'backgroundColor' => 'rgb(197,28,47)',
                    'borderColor' => 'rgb(197,28,47)',
                    'data' => $datas,
                ],
            ],
        ]);
        return $chart;
    }

    public function chartTwo(): Chart
    {
        $tmp = $this->sector->findAll();
        $labels = [];
        $data = [];
        $datas = [];

        foreach ($tmp as $tab) {
            $labels[] = $tab->getName();
            $data[] = count($this->student->findBy(['fistChoice' => $tab]));
            $datas[] = count($this->student->findBy(['secondChoice' => $tab]));
        }

        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);

        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Premier choix',
                    'backgroundColor' => 'rgb(249,209,16)',
                    'borderColor' => 'rgb(249,209,16)',
                    'data' => $data,
                ],
                [
                    'label' => 'Deuxième choix',
                    'backgroundColor' => 'rgb(197,28,47)',
                    'borderColor' => 'rgb(197,28,47)',
                    'data' => $datas,
                ],
            ],
        ]);
        return $chart;
    }

    public function chartConfirmOne(): Chart
    {
        $tmp = $this->faculty->findAll();

        $labels = [];
        $data = [];
        $datas = [];

        foreach ($tmp as $tab) {
            $labels[] = $tab->getName();
            $data[] = count($this->student->findBy(['facOne' => $tab, 'isVerified' => true]));
            $datas[] = count($this->student->findBy(['factTwo' => $tab, 'isVerified' => true]));
        }

        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);

        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Premier choix',
                    'backgroundColor' => 'rgb(249,209,16)',
                    'borderColor' => 'rgb(249,209,16)',
                    'data' => $data,
                ],
                [
                    'label' => 'Deuxième choix',
                    'backgroundColor' => 'rgb(197,28,47)',
                    'borderColor' => 'rgb(197,28,47)',
                    'data' => $datas,
                ],
            ],
        ]);
        return $chart;
    }
    public function chartConfirmTwo(): Chart
    {
        $tmp = $this->sector->findAll();

        $labels = [];
        $data = [];
        $datas = [];

        foreach ($tmp as $tab) {
            $labels[] = $tab->getName();
            $data[] = count($this->student->findBy(['fistChoice' => $tab, 'isVerified' => true]));
            $datas[] = count($this->student->findBy(['secondChoice' => $tab, 'isVerified' => true]));
        }

        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);

        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Premier choix',
                    'backgroundColor' => 'rgb(249,209,16)',
                    'borderColor' => 'rgb(249,209,16)',
                    'data' => $data,
                ],
                [
                    'label' => 'Deuxième choix',
                    'backgroundColor' => 'rgb(197,28,47)',
                    'borderColor' => 'rgb(197,28,47)',
                    'data' => $datas,
                ],
            ],
        ]);
        return $chart;
    }
}
