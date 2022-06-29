<?php

namespace App\EventSubscriber;

use App\Entity\Menu;
use App\Entity\Burger;
use App\Entity\Boisson;
use Doctrine\ORM\Events;
use App\Entity\PortionFrite;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private ?TokenInterface $token;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->token = $tokenStorage->getToken();
    }
    public static function getSubscribedEvents(): array
    {
        return [
        Events::prePersist,
        CheckPassportEvent::class => 'onCheckPassport',
        ];
    }
    public function onCheckPassport(CheckPassportEvent $event)
    {
        $passport = $event->getPassport();
        $user = $passport->getUser();
        //dd($user->isIsVerified());
        if ($user->isIsVerified() == false ) {
            throw new AuthenticationException();
        }
     }
    private function getUser()
    {
        //dd($this->token);
        if (null === $token = $this->token) {
            return null;
        }
        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return null;
        }
        return $user;
    }
    public function prePersist(LifecycleEventArgs $args)
    {
        if ($args->getObject() instanceof Burger) {
            $args->getObject()->setGestionnaire($this->getUser());
        }
        if ($args->getObject() instanceof Boisson) {
            $args->getObject()->setGestionnaire($this->getUser());
        }
        if ($args->getObject() instanceof PortionFrite) {
            $args->getObject()->setGestionnaire($this->getUser());
        }
        if ($args->getObject() instanceof Menu) {
            $args->getObject()->setGestionnaire($this->getUser());

            $prixMenu = 0;
            $burgers = $args->getObject()->getBurgers();
            $boissons = $args->getObject()->getTailleBoissons();
            $frites = $args->getObject()->getPortionFrites();

            foreach($burgers as $burger ){
                $prixMenu += $burger->getPrix();
            }
            foreach($boissons as $boisson ){
                $prixMenu += $boisson->getPrix();
            }
            foreach($frites as $frite ){
                $prixMenu += $frite->getPrix();
            }
          
            $args->getObject()->setPrix($prixMenu);
        }
    }
}
