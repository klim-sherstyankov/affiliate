<?php

namespace App\Security;

use App\Repository\AccessTokenRepository;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private AccessTokenRepository $repository
    ) {
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {
        dd($accessToken);
        // например, запрос к базе данных "access token", чтобы искать этот токен
        $accessToken = $this->repository->findOneByValue($token);
        if (null === $accessToken || !$accessToken->isValid()) {
            throw new BadCredentialsException('Invalid credentials.');
        }

        // и вернуть объект UserBadge, содержащий идентификатор пользователя из найденного токена
        return new UserBadge($accessToken->getUserId());
    }
}
