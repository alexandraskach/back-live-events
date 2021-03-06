<?php 

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Actualite;
use App\Entity\Comment;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthoredEntitySubscriber implements EventSubscriberInterface {

    /**
     * @var TokenStorageInterface
     */

    private $tokenStorage;


    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage=$tokenStorage;
    }

    public static function getSubscribedEvents() {
        return [
            KernelEvents::VIEW => ['getAuthenticatedUser', EventPriorities::PRE_WRITE]
        ];
    }

    public function getAuthenticatedUser(ViewEvent $event){

        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        $token = $this->tokenStorage->getToken();

        if (null === $token){
            return;
        }

        /** @var UserInterface $author */
        $author = $token->getUser();

        if ((!$entity instanceof Actualite && !$entity instanceof Comment) || Request::METHOD_POST !== $method) {
            return; 
        }
        $entity->setAuthor($author);
    }
    


}