<?php
/**
 * Created by IntelliJ IDEA.
 * User: si2001
 * Date: 12/6/18
 * Time: 5:19 PM
 */

namespace App\Controller\Rest;

use App\Entity\Role;
use App\Entity\Skill;
use App\Entity\Status;
use App\Entity\User;
use DateTime;
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
     * http://localhost:8000/api/user
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

        // check if nullable fields are present, then insert
        if($birthday = \DateTime::createFromFormat('Y-m-d', $request->get("birthday")))
            $user->setBirthday($birthday);
        if($country = $request->get("country"))
            $user->setCountry($country);
        if($image = $request->get("image"))
            $user->setLink($image);
        $em = $this->getDoctrine()->getManager();
        if($status = $request->get("status")){
            $myId = $status["id"];
            $myStatus = $em->getRepository(Status::class)->find($myId);
            $user->setStatus($myStatus);
        }
        if($roles = $request->get("roles")){
            foreach($roles as  $role){
                $myId = $role["id"];
                $myRole = $em->getRepository(Role::class)->find($myId);
                $user->addRole($myRole);
            }
        }
        if($skills = $request->get("skills")){
            foreach($skills as  $skill){
                $myId = $skill["id"];
                $mySkill = $em->getRepository(Skill::class)->find($myId);
                $user->addSkillId($mySkill);
            }
        }

        $em->persist($user);
        $em->flush();

        return View::create($user, Response::HTTP_CREATED , []);
    }

    /**
     * http://localhost:8000/api/user/2
     * Replaces User resource
     * @FOSRest\Put("/user/{id}")
     * @param int $id
     * @param Request $request
     *
     * @return View
     */
    public function putUser(int $id, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        if($user) {
            // insert not-nullable fields
            $user->setUsername($request->get("username"));
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $request->get("username")));
            $user->setName($request->get("name"));
            $user->setSurname($request->get("surname"));

            // check if nullable fields are present, then insert
            if($birthday = \DateTime::createFromFormat('Y-m-d', $request->get("birthday")))
                $user->setBirthday($birthday);
            if($country = $request->get("country"))
                $user->setCountry($country);
            if($image = $request->get("image"))
                $user->setLink($image);
            $em = $this->getDoctrine()->getManager();
            if($status = $request->get("status")){
                $myId = $status["id"];
                $myStatus = $em->getRepository(Status::class)->find($myId);
                $user->setStatus($myStatus);
            }
            if($roles = $request->get("roles")){
                foreach($roles as  $role){
                    $myId = $role["id"];
                    $myRole = $em->getRepository(Role::class)->find($myId);
                    $user->addRole($myRole);
                }
            }
            if($skills = $request->get("skills")){
                foreach($skills as  $skill){
                    $myId = $skill["id"];
                    $mySkill = $em->getRepository(Skill::class)->find($myId);
                    $user->addSkillId($mySkill);
                }
            }
        }
        else {
            throw $this->createNotFoundException(
                'No user found for id ' . $id
            );
        }

        $em->persist($user);
        $em->flush();

        return View::create($user, Response::HTTP_CREATED , []);
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
        $user = $em->getRepository(User::class)->find($id);

        if ($user) {
            $em->remove($user);
        }
        else {
            throw $this->createNotFoundException(
                'No user found for id '. $id
            );
        }

        $em->flush();
        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return new JsonResponse(array('data' => 123, 'message' => 'User successfully removed!'));
    }

    /**
     * http://localhost:8000/api/usersearch/country=italy
     * Lists all Users born in a country.
     * @FOSRest\Get("/usersearch/")
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

    /**
     * http://localhost:8000/api/userrole/1
     * Find User.
     * @FOSRest\Get("/userrole/{id}")
     * @param int $id
     *
     * @return View
     */
    public function getRolesByUserAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        // $user = $em->getRepository(User::class)->findBy(array('id' => $id)); this returns an object to serialize
        $user = $em->getRepository(User::class)->find($id);

        return View::create($user->getRoles(), Response::HTTP_CREATED , []);
    }

}