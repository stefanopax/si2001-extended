<?php
/**
 * Created by IntelliJ IDEA.
 * Skill: si2001
 * Date: 12/6/18
 * Time: 5:19 PM
 */

namespace App\Controller\Rest;

use App\Entity\Skill;
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

class SkillController extends FOSRestController
{

    /**
     * http://localhost:8000/api/skill
     * Lists all Skills.
     * @FOSRest\Get("/skill")
     *
     * @return View
     */
    public function getSkillsAction()
    {
        $repository = $this->getDoctrine()->getRepository(Skill::class);
        $skills = $repository->findAll();

        /*
            If we need to serialize an object:
            // normalizers turn objects into arrays
            $normalizers = array(new ObjectNormalizer());
            // encoders turn arrays into specific formats such as Json or Xml
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            // this process is called serialization
            $serializer = new Serializer($normalizers, $encoders);
            $serializer->serialize($skills, 'json');
         */

        return View::create($skills, Response::HTTP_CREATED , []);
    }

    /**
     * http://localhost:8000/api/skill/1
     * Find Skill.
     * @FOSRest\Get("/skill/{id}")
     * @param int $id
     *
     * @return View
     */
    public function getSkillAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        // $skill = $em->getRepository(Skill::class)->findBy(array('id' => $id)); this returns an object to serialize
        $skill = $em->getRepository(Skill::class)->find($id);

        return View::create($skill, Response::HTTP_CREATED , []);
    }

    /**
     * http://localhost:8000/api/skill?name=myskill
     * Create Skill.
     * @FOSRest\Post("/skill")
     * @param Request $request
     *
     * @return View
     */
    public function postSkillAction(Request $request)
    {
        $skill = new Skill();
        // insert not-nullable fields
        $skill->setName($request->get("name"));

        $em = $this->getDoctrine()->getManager();

        $em->persist($skill);
        $em->flush();

        return View::create($skill, Response::HTTP_CREATED , []);
    }

    /**
     * http://localhost:8000/api/skill/2?name=skill10
     * Replaces Skill resource
     * @FOSRest\Put("/skill/{id}")
     * @param int $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function putSkill(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $skill = $em->getRepository(Skill::class)->find($id);

        if($skill) {
            $skill->setName($request->get('name'));
        }
        else {
            throw $this->createNotFoundException(
                'No skill found for id ' . $id
            );
        }

        $em->persist($skill);
        $em->flush();
        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        return new JsonResponse(array('data' => 123, 'message' => 'Skill successfully updated!'));
    }

    /**
     * http://localhost:8000/api/skill/8
     * Removes the Skill resource
     * @FOSRest\Delete("/skill/{id}")
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteSkill(int $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $skill= $em->getRepository(Skill::class)->find($id);

        if ($skill) {
            $em->remove($skill);
        }
        else {
            throw $this->createNotFoundException(
                'No skill found for id '.$id
            );
        }

        $em->flush();
        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return new JsonResponse(array('data' => 123, 'message' => 'Skill successfully removed!'));
    }

}