<?php

namespace App\Service;

use App\Exceptions\User\NotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

class SentryService
{
    public function addUserInformations(?UserInterface $user): UserInterface
    {
//        $this->throwError();
        if (!$user instanceof UserInterface) {
            throw new NotFoundException('No user given');
        }

        // We have a user in session, we look for his information in DB and return it
        // ...
        return $user;
    }

    private function throwError(): void
    {
        throw new \Exception('fatal error for x or y reason');
    }
}