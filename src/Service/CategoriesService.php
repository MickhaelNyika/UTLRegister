<?php
namespace App\Service;

use App\Repository\DbCategoriesRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CategoriesService{
    private $repoCategory;
    private $requestStack;

    public function __construct(RequestStack $requestStack, DbCategoriesRepository $repoCategory){
        $this->repoCategory = $repoCategory;
        $this->requestStack = $requestStack;
    }

    public function updateSession(){
        $session = $this->requestStack->getSession();
        $Categories = $this->repoCategory->findAll();
        $session->set("Cat", $Categories);
    }
}