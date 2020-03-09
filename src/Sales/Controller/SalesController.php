<?php

declare(strict_types=1);

namespace App\Sales\Controller;

use App\Sales\SalesGenerator\SalesGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class SalesController extends AbstractController
{
    private const SALES_COUNT_PER_CONSUMER = 5;

    private SalesGeneratorInterface $salesGenerator;

    public function __construct(SalesGeneratorInterface $salesGenerator)
    {
        $this->salesGenerator = $salesGenerator;
    }

    /**
     * @Route(path="/api/sales", methods={"POST"})
     */
    public function buy()
    {
        $this->salesGenerator->generate(self::SALES_COUNT_PER_CONSUMER);

        return null;
    }
}
