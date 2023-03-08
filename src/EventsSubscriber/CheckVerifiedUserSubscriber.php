<?php

namespace App\EventsSubscriber;

use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;
use App\Entity\User;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class CheckVerifiedUserSubscriber implements EventSubscriberInterface
{
    public function onCheckPassport(CheckPassportEvent $event)
    {
        // dd($event);

        $passport = $event->getPassport();
        // if (!$passport instanceof UserPassportInterface) {
        //     throw new \Exception('Unexpected passport type');
        // }

        $user = $passport->getUser();
        if (!$user instanceof User) {
            throw new \Exception('Unexpected user type');
        }

        if (!$user->isVerified()) {
            // throw new AuthenticationException();
            throw new CustomUserMessageAuthenticationException(
                'Please validate your account to log in.'
            );
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CheckPassportEvent::class => ['onCheckPassport', -10],
        ];
    }
}

