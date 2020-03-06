<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HealthCheckController extends AbstractController
{
    /**
     * @Route(path="/health-check", methods={"GET"})
     */
    public function healthCheck(): Response
    {
        return new Response();
    }
}
