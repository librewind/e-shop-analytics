<?php

declare(strict_types=1);

namespace App\Analytics\Controller;

use App\Analytics\Form\Type\GetCountSoldProductsPerDayByPromotionIdType;
use App\Analytics\Form\Type\GetCountUniqCustomersPerDayByPromotionIdType;
use App\Analytics\Repository\FactSaleRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class FactSaleController extends AbstractController
{
    private FactSaleRepositoryInterface $factSaleRepository;

    public function __construct(FactSaleRepositoryInterface $factSaleRepository)
    {
        $this->factSaleRepository = $factSaleRepository;
    }

    /**
     * @Route(path="/api/reports/count-uniq-customers-per-day-by-promotion", methods={"GET"})
     */
    public function getCountUniqCustomersPerDayByPromotionId(Request $request)
    {
        $form = $this->createForm(GetCountUniqCustomersPerDayByPromotionIdType::class);
        $form->submit($request->query->all());
        if (!$form->isValid()) {
            return $form;
        }

        $data = $form->getData();
        $promotionId = $data['promotionId'];

        return $this->factSaleRepository->getCountUniqCustomersPerDayByPromotionId($promotionId);
    }

    /**
     * @Route(path="/api/reports/count-sold-products-per-day-by-promotion", methods={"GET"})
     */
    public function getCountSoldProductsPerDayByPromotionId(Request $request)
    {
        $form = $this->createForm(GetCountSoldProductsPerDayByPromotionIdType::class);
        $form->submit($request->query->all());
        if (!$form->isValid()) {
            return $form;
        }

        $data = $form->getData();
        $promotionId = $data['promotionId'];

        return $this->factSaleRepository->getCountSoldProductsPerDayByPromotionId($promotionId);
    }

    /**
     * @Route(path="/api/reports/net-sales-per-day", methods={"GET"})
     */
    public function getNetSalesPerDay()
    {
        return $this->factSaleRepository->getNetSalesPerDay();
    }
}
