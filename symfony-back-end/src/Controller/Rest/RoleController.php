<?php

namespace App\Controller\Rest;

use App\Entity\Role;
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

class RoleController extends FOSRestController
{

    /**
     * http://localhost:8000/api/role
     * Lists all Roles.
     * @FOSRest\Get("/role")
     *
     * @return View
     */
    public function getRolesAction()
    {
        $repository = $this->getDoctrine()->getRepository(Role::class);
        $roles = $repository->findAll();

        /*
            If we need to serialize an object:
            // normalizers turn objects into arrays
            $normalizers = array(new ObjectNormalizer());
            // encoders turn arrays into specific formats such as Json or Xml
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            // this process is called serialization
            $serializer = new Serializer($normalizers, $encoders);
            $serializer->serialize($roles, 'json');
         */

        return View::create($roles, Response::HTTP_CREATED, []);
    }

    /**
     * http://localhost:8000/api/role/1
     * Find Role.
     * @FOSRest\Get("/role/{id}")
     * @param int $id
     *
     * @return View
     */
    public function getRoleAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        // $role = $em->getRepository(Role::class)->findBy(array('id' => $id)); this returns an object to serialize
        $role = $em->getRepository(Role::class)->find($id);

        return View::create($role, Response::HTTP_CREATED, []);
    }

    /**
     * http://localhost:8000/api/role?name=myrole
     * Create Role.
     * @FOSRest\Post("/role")
     * @param Request $request
     *
     * @return View
     */
    public function postRoleAction(Request $request)
    {
        $role = new Role();
        // insert not-nullable fields
        $role->setName($request->get("name"));

        $em = $this->getDoctrine()->getManager();

        $em->persist($role);
        $em->flush();

        return View::create($role, Response::HTTP_CREATED, []);
    }

    /**
     * http://localhost:8000/api/role/2?name=role10
     * Replaces Role resource
     * @FOSRest\Put("/role/{id}")
     * @param int $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function putRole(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $role = $em->getRepository(Role::class)->find($id);

        if ($role) {
            $role->setName($request->get('name'));
        } else {
            throw $this->createNotFoundException(
                'No role found for id ' . $id
            );
        }

        $em->persist($role);
        $em->flush();
        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        return new JsonResponse(array('data' => 123, 'message' => 'Role successfully updated!'));
    }

    /**
     * http://localhost:8000/api/role/8
     * Removes the Role resource
     * @FOSRest\Delete("/role/{id}")
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteRole(int $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $role = $em->getRepository(Role::class)->find($id);

        if ($role) {
            $em->remove($role);
        } else {
            throw $this->createNotFoundException(
                'No role found for id ' . $id
            );
        }

        $em->flush();
        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return new JsonResponse(array('data' => 123, 'message' => 'Role successfully removed!'));
    }
}

