<?php

namespace App\Security;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use App\Exception\InvalidConfirmationTokenException;

class UserConfirmationService
{
    /**
     * @var UsersRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        UsersRepository $userRepository,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    )
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function confirmUser(string $confirmationToken)
    {   
        $this->logger->debug('Fetching user by confirmation token');
        $user = $this->userRepository->findOneBy([
            'confirmationToken' => $confirmationToken
        ]);

        if (!$user) {
            $this->logger->debug('User by confirmation token not found');
            throw new InvalidConfirmationTokenException();
        }
        $user->setEnabled(true);
        $user->setConfirmationToken(null);
        $user = $this->entityManager->flush();

        $this->logger->debug('Confirmed user by confirmation token');

       
    }
}