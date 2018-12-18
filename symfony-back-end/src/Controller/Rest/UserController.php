<?php
/**
 * Created by IntelliJ IDEA.
 * User: si2001
 * Date: 12/6/18
 * Time: 5:19 PM
 */

namespace App\Controller\Rest;

use App\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UserController extends FOSRestController
{

    /**
     * http://localhost:8000/api/user
     * Lists all Users.
     * @FOSRest\Get("/user")
     *
     * @return View
     */
    public function getUsersAction()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();

        /*
            If we need to serialize an object:
            // normalizers turn objects into arrays
            $normalizers = array(new ObjectNormalizer());
            // encoders turn arrays into specific formats such as Json or Xml
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            // this process is called serialization
            $serializer = new Serializer($normalizers, $encoders);
            $serializer->serialize($users, 'json');
         */

        return View::create($users, Response::HTTP_CREATED , []);
    }

    /**
     * http://localhost:8000/api/user/1
     * Find User.
     * @FOSRest\Get("/user/{id}")
     * @param int $id
     *
     * @return View
     */
    public function getUserAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        // $user = $em->getRepository(User::class)->findBy(array('id' => $id)); this returns an object to serialize
        $user = $em->getRepository(User::class)->find($id);

        return View::create($user, Response::HTTP_CREATED , []);
    }

    /**
     * http://localhost:8000/api/user?name=user&surname=myuser&username=user&password=user
     * Create User.
     * @FOSRest\Post("/user")
     * @param Request $request
     *
     * @return View
     */
    public function postUserAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        // insert not-nullable fields
        $user->setUsername($request->get("username"));
        $user->setPassword(
            $passwordEncoder->encodePassword($user, $request->get("username")));
        $user->setName($request->get("name"));
        $user->setSurname($request->get("surname"));

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();

        return View::create($user, Response::HTTP_CREATED , []);
    }

    /**
     * http://localhost:8000/api/user/2?name=user10
     * Replaces User resource
     * @FOSRest\Put("/user/{id}")
     * @param int $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function putUser(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        if($user) {
            $user->setName($request->get('name'));
        }
        else {
            throw $this->createNotFoundException(
                'No user found for id ' . $id
            );
        }

        $em->persist($user);
        $em->flush();
        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        return new JsonResponse(array('data' => 123, 'message' => 'User successfully updated!'));
    }

    /**
     * http://localhost:8000/api/user/17
     * Removes the User resource
     * @FOSRest\Delete("/user/{id}")
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteUser(int $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $user= $em->getRepository(User::class)->find($id);

        if ($user) {
            $em->remove($user);
        }
        else {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $em->flush();
        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return new JsonResponse(array('data' => 123, 'message' => 'User successfully removed!'));
    }

    /**
     * http://localhost:8000/api/user/search/?country=italy
     * Lists all Users born in a country.
     * @FOSRest\Get("/user/search/")
     * @param Request $request
     *
     * @return View
     */
    public function getUsersByCountryAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findBy(array("country"=>$request->get('country')));

        return View::create($users, Response::HTTP_CREATED , []);
    }

}