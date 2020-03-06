<?php

declare(strict_types=1);

namespace App\Analytics\Controller;

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

        $countUniqCustomersPerDayByPromotionId = $this->factSaleRepository->getCountUniqCustomersPerDayByPromotionId($promotionId);

        return $countUniqCustomersPerDayByPromotionId;
    }
}
