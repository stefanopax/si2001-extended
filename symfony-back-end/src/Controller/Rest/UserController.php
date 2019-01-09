<?php

namespace App\Controller\Rest;

use App\Entity\Role;
use App\Entity\Skill;
use App\Entity\Status;
use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\SkillRepository;
use App\Repository\StatusRepository;
use App\Repository\UserRepository;
use App\Service\UserService;
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
    public function getUsersAction(UserRepository $repository, UserService $myService)
    {
        $users = $myService->findAll($repository);

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
    public function getUserAction(UserRepository $repository, UserService $myService, int $id)
    {
        // $user = $em->getRepository(User::class)->findBy(array('id' => $id)); this returns an object to serialize
        $user = $myService->findOne($repository, $id);

        return View::create($user, Response::HTTP_CREATED , []);
    }

    /**
     * http://localhost:8000/api/user
     * Body:
     * {"username":"testuser","password":"mynewpass","roles":[{"id":2, "name":"ROLE_ADMIN"}],"name":"Test",	"surname":"User",
     *  "birthday":"2018-09-09","country": "Sweden","image":"person.jpg","skills":[{"id":5,"name":"Javascript"}],"status":{"id":2,"name":"Married"}}
     * Create User.
     * @FOSRest\Post("/user")
     * @param Request $request
     *
     * @return View
     */
    public function postUserAction(UserRepository $userRepository, SkillRepository $skillRepository,
        StatusRepository $statusRepository, RoleRepository $roleRepository, Request $request,
        UserPasswordEncoderInterface $passwordEncoder, UserService $myService)
    {
        $user = new User();
        $em = $this->getDoctrine()->getManager();
        $newUser = $myService->createOne($em, $userRepository, $skillRepository, $statusRepository, $roleRepository, $user, $request, $passwordEncoder);

        return View::create($newUser, Response::HTTP_CREATED , []);
    }

    /**
     * http://localhost:8000/api/user/2
     * Replaces User resource
     * @FOSRest\Put("/user/{id}")
     * @param int $id
     * @param Request $request
     *
     * @return View
     * @throws \Exception
     */
    public function putUser(int $id, UserRepository $userRepository, SkillRepository $skillRepository,
        StatusRepository $statusRepository, RoleRepository $roleRepository, Request $request,
        UserPasswordEncoderInterface $passwordEncoder, UserService $myService)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $myService->updateOne($id, $em, $userRepository, $skillRepository, $statusRepository, $roleRepository, $request, $passwordEncoder);

        return View::create($user, Response::HTTP_CREATED , []);
    }

    /**
     * http://localhost:8000/api/user/17
     * Removes the User resource
     * @FOSRest\Delete("/user/{id}")
     * @param int $id
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteUser(int $id, UserService $userService, UserRepository $userRepository): JsonResponse
    {

        $em = $this->getDoctrine()->getManager();
        $userService->deleteOne($id, $userRepository, $em);

        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return new JsonResponse(array('data' => 123, 'message' => 'User successfully removed!'));
    }

    /*
     * useless since I can filter data in the front-end
    /**
     * http://localhost:8000/api/usersearch/?country=italy
     * Lists all Users born in a country.
     * @FOSRest\Get("/usersearch/{country}")
     * @param Request $request
     *
     * @return View

    public function getUsersByCountryAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findBy(array("country"=>$request->get('country')));

        return View::create($users, Response::HTTP_CREATED , []);
    }
    */

}