<?php

namespace App\DataFixtures;

use App\Entity\Actualite;
use App\Entity\BlogPost;
use App\Entity\Comment;
use App\Entity\Users;
use App\Security\TokenGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectManager as PersistenceObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var \Faker\Factory
     */
    private $faker;

    private const USERS = [
        [
            'username' => 'admin',
            'email' => 'admin@blog.com',
            'name' => 'ADministrateur',
            'password' => 'secret123#',
            'roles' => [Users::ROLE_SUPERADMIN],
            'enabled' => true
        ],
        [
            'username' => 'john_doe',
            'email' => 'john@blog.com',
            'name' => 'John Doe',
            'password' => 'secret123#',
            'roles' => [Users::ROLE_ADMIN],
            'enabled' => true
        ],
        [
            'username' => 'rob_smith',
            'email' => 'rob@blog.com',
            'name' => 'Rob Smith',
            'password' => 'secret123#',
            'roles' => [Users::ROLE_WRITER],
            'enabled' => true
        ],
        [
            'username' => 'jenny_rowling',
            'email' => 'jenny@blog.com',
            'name' => 'Jenny Rowling',
            'password' => 'secret123#',
            'roles' => [Users::ROLE_WRITER],
            'enabled' => true
        ],
        [
            'username' => 'han_solo',
            'email' => 'han@blog.com',
            'name' => 'Han Solo',
            'password' => 'secret123#',
            'roles' => [Users::ROLE_EDITOR],
            'enabled' => false
        ],
        [
            'username' => 'jedi_knight',
            'email' => 'jedi@blog.com',
            'name' => 'Jedi Knight',
            'password' => 'secret123#',
            'roles' => [Users::ROLE_COMMENTATOR],
            'enabled' => true
        ],
    ];
    /**
     * @var TokenGenerator
     */
    private $tokenGenerator;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        TokenGenerator $tokenGenerator
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = \Faker\Factory::create();
        $this->tokenGenerator = $tokenGenerator;
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(PersistenceObjectManager $manager)
    {
        $this->loadUsers($manager);
        // $this->loadBlogPosts($manager);
        // $this->loadComments($manager);
    }

    // public function loadBlogPosts(PersistenceObjectManager $manager)
    // {
    //     for ($i = 0; $i < 100; $i++) {
    //         $blogPost = new Actualite();
    //         $blogPost->setTitle($this->faker->realText(30));
    //         $blogPost->setDate($this->faker->dateTimeThisYear);
    //         $blogPost->setContent($this->faker->realText());

    //         $authorReference = $this->getRandomUserReference($blogPost);

    //         $blogPost->setAuthor($authorReference);
    //         $blogPost->setSlug($this->faker->slug);

    //         $this->setReference("blog_post_$i", $blogPost);

    //         $manager->persist($blogPost);
    //     }

    //     $manager->flush();
    // }

    // public function loadComments(PersistenceObjectManager $manager)
    // {
    //     for ($i = 0; $i < 100; $i++) {
    //         for ($j = 0; $j < rand(1, 10); $j++) {
    //             $comment = new Comment();
    //             $comment->setContent($this->faker->realText());
    //             $comment->setDate($this->faker->dateTimeThisYear);

    //             $authorReference = $this->getRandomUserReference($comment);

    //             $comment->setAuthor($authorReference);
    //             $comment->setActualite($this->getReference("blog_post_$i"));

    //             $manager->persist($comment);
    //         }
    //     }

    //     $manager->flush();
    // }

    public function loadUsers(PersistenceObjectManager $manager)
    {
        foreach (self::USERS as $userFixture) {
            $user = new Users();
            $user->setUsername($userFixture['username']);
            $user->setMail($userFixture['mail']);
            $user->setName($userFixture['name']);

            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $userFixture['password']
                )
            );
            $user->setRoles($userFixture['roles']);
            $user->setEnabled($userFixture['enabled']);

            if (!$userFixture['enabled']) {
                $user->setConfirmationToken(
                    $this->tokenGenerator->getRandomSecureToken()
                );
            }

            $this->addReference('user_'.$userFixture['username'], $user);

            $manager->persist($user);
        }

        $manager->flush();
    }

    protected function getRandomUserReference($entity): Users
    {
        $randomUser = self::USERS[rand(0, 5)];

        if ($entity instanceof Actualite && !count(
                array_intersect(
                    $randomUser['roles'],
                    [Users::ROLE_SUPERADMIN, Users::ROLE_ADMIN, Users::ROLE_WRITER]
                )
            )) {
            return $this->getRandomUserReference($entity);
        }

        if ($entity instanceof Comment && !count(
                array_intersect(
                    $randomUser['roles'],
                    [
                        Users::ROLE_SUPERADMIN,
                        Users::ROLE_ADMIN,
                        Users::ROLE_WRITER,
                        Users::ROLE_COMMENTATOR,
                    ]
                )
            )) {
            return $this->getRandomUserReference($entity);
        }


        return $this->getReference(
            'user_'.$randomUser['username']
        );
    }
}