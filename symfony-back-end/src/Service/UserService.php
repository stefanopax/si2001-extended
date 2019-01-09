<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\SkillRepository;
use App\Repository\StatusRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    public function findAll(UserRepository $repository)
    {
        return $repository->findAll();
    }

    public function findOne(UserRepository $repository, int $id)
    {
        return $repository->find($id);
    }

    public function createOne (ObjectManager $em, UserRepository $userRepository, SkillRepository $skillRepository,
        StatusRepository $statusRepository, RoleRepository $roleRepository, User $user, Request $request,
        UserPasswordEncoderInterface $passwordEncoder)
    {
        // insert not-nullable fields
        $user->setUsername($request->get("username"));
        /** @noinspection PhpParamsInspection */
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
        if($status = $request->get("status")){
            $myId = $status["id"];
            $myStatus = $statusRepository->find($myId);
            $user->setStatus($myStatus);
        }
        // clean user in case it comes from updateOne()
        if($roles = $request->get("roles")){
            $allRoles = $roleRepository->findAll();
            foreach ($allRoles as $role){
                $user->removeRole($role);
            }
            foreach($roles as  $role){
                $myId = $role["id"];
                $myRole = $roleRepository->find($myId);
                $user->addRole($myRole);
            }
        }
        if($skills = $request->get("skills")){
            $allSkills = $skillRepository->findAll();
            foreach ($allSkills as $skill){
                $user->removeSkillId($skill);
            }
            foreach($skills as  $skill){
                $myId = $skill["id"];
                $mySkill = $skillRepository->find($myId);
                $user->addSkillId($mySkill);
            }
        }

        $em->persist($user);
        $em->flush();

        return $user;
    }

    public function updateOne(int $id, ObjectManager $em, UserRepository $userRepository, SkillRepository $skillRepository,
        StatusRepository $statusRepository, RoleRepository $roleRepository, Request $request,
        UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $userRepository->find($id);
        if($user)
            // this avoids the repetition of the same controls
            $this->createOne($em, $userRepository, $skillRepository, $statusRepository, $roleRepository, $user, $request, $passwordEncoder);
        else
            throw new Exception('No user found for id ' . $id);
    }

    public function deleteOne(int $id, UserRepository $userRepository, ObjectManager $em)
    {
        $user = $userRepository->find($id);

        if ($user)
            $em->remove($user);
        else
            throw new Exception('No user found for id ' . $id);

        $em->flush();
    }
}