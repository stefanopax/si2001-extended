<?php
/**
 * Created by IntelliJ IDEA.
 * User: si2001
 * Date: 12/6/18
 * Time: 5:19 PM
 */

namespace App\Controller\Rest;

use App\Entity\Article;
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

class ArticleController extends FOSRestController
{

    /**
     * http://localhost:8000/api/articles
     * Lists all Articles.
     * @FOSRest\Get("/articles")
     *ArticleController.php
     * @return View
     */
    public function getArticles()
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repository->findAll();

        // normalizers turn objects into arrays
        $normalizers = array(new ObjectNormalizer());
        // encoders turn arrays into specific formats such as Json or Xml
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        // this process is called serialization
        $serializer = new Serializer($normalizers, $encoders);
        $serializer->serialize($articles, 'json');

        return View::create($articles, Response::HTTP_CREATED , []);
    }

    /**
     * http://localhost:8000/api/articles/1
     * Find User.
     * @FOSRest\Get("/articles/{id}")
     * @param int $id
     *
     * @return View
     */
    public function getArticle(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        // $article = $em->getRepository(User::class)->findBy(array('id' => $id)); this returns an object to serialize
        $article = $em->getRepository(Article::class)->find($id);

        return View::create($article, Response::HTTP_CREATED , []);
    }

    /**
     * http://localhost:8000/api/articles?name=mynewarticle
     * Create User.
     * @FOSRest\Post("/articles")
     * @param Request $request
     *
     * @return View
     */
    public function postArticle(Request $request)
    {
        $article = new Article();
        $article->setName($request->get("name"));
        $em = $this->getDoctrine()->getManager();

        $em->persist($article);
        $em->flush();

        return View::create($article, Response::HTTP_CREATED , []);
    }

    /**
     * http://localhost:8000/api/articles/6?name=article17&position=17
     * Replaces User resource
     * @FOSRest\Put("/articles/{id}")
     * @param int $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function putArticle(int $id, Request $request): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);

        if($article)
            $article->setName($request->get('name'));
        else
            throw $this->createNotFoundException(
                'No article found for id '.$id
            );

        $em->persist($article);
        $em->flush();
        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        return new JsonResponse(array('data' => 123, 'message' => 'User successfully updated!'));
    }

    /**
     * http://localhost:8000/api/articles/17
     * Removes the User resource
     * @FOSRest\Delete("/articles/{id}")
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteArticle(int $id): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $article= $em->getRepository(Article::class)->find($id);

        if ($article) {
            $em->remove($article);
        }
        else
            throw $this->createNotFoundException(
                'No article found for id '.$id
            );
        $em->flush();
        // In case our DELETE was a success we need to return a 204 HTTP NO CONTENT response. The object is deleted.
        return new JsonResponse(array('data' => 123, 'message' => 'User successfully removed!'));
    }

}