<?php

namespace App\Controller;

use App\Exception\User\NotFoundException;
use App\Service\SentryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

#[Route('/sentry-test', name: 'sentry_test_')]
class SentryTestController extends AbstractController
{
    #[Route('/one', name: 'one')]
    public function testLog()
    {
        // the following code will test if an uncaught exception logs to sentry
        throw new \RuntimeException('Example exception.');
    }

    #[Route('/two', name: 'two')]
    public function secondTestLog(
        SentryService $sentryService
    ): JsonResponse
    {
        try {
            $user = $this->getUser();

            $data = $sentryService->addUserInformations($user);
        } catch (NotFoundException $notFoundException) {
            // Normal error, no need to capture it
            \Sentry\captureException($notFoundException);

            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        } catch (Throwable $exception) {
            \Sentry\captureException($exception);

            return new JsonResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        new JsonResponse($data);
    }
}