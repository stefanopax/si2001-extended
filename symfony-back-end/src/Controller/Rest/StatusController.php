<?php

namespace App\Controller\Rest;

use App\Entity\Status;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class StatusController extends FOSRestController
{

    /**
     * http://localhost:8000/api/status
     * Lists all Status.
     * @FOSRest\Get("/status")
     *
     * @return View
     */
    public function getStatusAction()
    {
        $repository = $this->getDoctrine()->getRepository(Status::class);
        $status = $repository->findAll();

        /*
            If we need to serialize an object:
            // normalizers turn objects into arrays
            $normalizers = array(new ObjectNormalizer());
            // encoders turn arrays into specific formats such as Json or Xml
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            // this process is called serialization
            $serializer = new Serializer($normalizers, $encoders);
            $serializer->serialize($status, 'json');
         */

        return View::create($status, Response::HTTP_CREATED , []);
    }

    /**
     * http://localhost:8000/api/status/1
     * Find Status.
     * @FOSRest\Get("/status/{id}")
     * @param int $id
     *
     * @return View
     */
    public function getOneStatusAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        // $status = $em->getRepository(Status::class)->findBy(array('id' => $id)); this returns an object to serialize
        $status = $em->getRepository(Status::class)->find($id);

        return View::create($status, Response::HTTP_CREATED , []);
    }

    /**
     * http://localhost:8000/api/status?name=mystatus
     * Create Status.
     * @FOSRest\Post("/status")
     * @param Request $request
     *
     * @return View
     */
    public function postStatusAction(Request $request)
    {
        $status = new Status();
        // insert not-nullable fields
        $status->setName($request->get("name"));

        $em = $this->getDoctrine()->getManager();

        $em->persist($status);
        $em->flush();

        return View::create($status, Response::HTTP_CREATED , []);
    }

    /**
     * http://localhost:8000/api/status/2?name=status10
     * Replaces Status resource
     * @FOSRest\Put("/status/{id}")
     * @param int $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function putStatus(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $status = $em->getRepository(Status::class)->find($id);

        if($status) {
            $status->setName($request->get('name'));
        }
        else {
            throw $this->createNotFoundException(
                'No status found for id ' . $id
            );
        }

        $em->persist($status);
        $em->flush();
        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        return new JsonResponse(array('data' => 123, 'message' => 'Status successfully updated!'));
    }

    /**
     * http://localhost:8000/api/status/17
     * Removes the Status resource
     * @FOSRest\Delete("/status/{id}")
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteStatus(int $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $status= $em->getRepository(Status::class)->find($id);

        if ($status) {
            $em->remove($status);
        }
        else {
            throw $this->createNotFoundException(
                'No status found for id '.$id
            );
        }

        $em->flush();
        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return new JsonResponse(array('data' => 123, 'message' => 'Status successfully removed!'));
    }

}