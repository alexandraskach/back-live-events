<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Repository\ActualiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ApiActualiteController extends AbstractController
{
 
    /**
     * @Route("/actualite/{id}", name="blog_by_id", requirements={"id"="\d+"}, methods={"GET"})
     */

    public function post(Actualite $actualite) 
    {   
        return $this->json($actualite);
       
    }

     /**
     * @Route("/actualite/add", name="blog_add", methods={"POST"})
     */

    public function add(Request $request) 
    {   
        /** @var Serializer $serializer  */
        $serializer->$this->get('serializer');
        $actualite=$serializer->deserialize($request->getContent(), Actualite::class, 'json');
        $em = $this->getDoctrine()->getManager();
        $em -> persist($actualite);
        $em -> flush();

        return $this->json($actualite);
    }

      /**
     * @Route("/actualite/post/{id}", name="blog_delete", methods={"DELETE"})
     */

    public function delete(Actualite $actualite) 
    {   
      
        $em = $this->getDoctrine()->getManager();
        $em -> remove($actualite);
        $em -> flush();

        return  new JsonResponse(null,Response::HTTP_NO_CONTENT);
    }

}
