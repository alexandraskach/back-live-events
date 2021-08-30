<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Entity\Concert;
use App\Entity\Actualite;
use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Notification;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class adminController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Back office Live Events');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fas fa-list', Users::class);
        yield MenuItem::linkToCrud('Concert', 'fas fa-list', Concert::class);
        yield MenuItem::linkToCrud('Actualite', 'fas fa-list', Actualite::class);
        yield MenuItem::linkToCrud('Image', 'fas fa-list', Image::class);
        yield MenuItem::linkToCrud('Notification', 'fas fa-list', Notification::class);
        yield MenuItem::linkToCrud('Comment', 'fas fa-list', Comment::class);

    }
}
