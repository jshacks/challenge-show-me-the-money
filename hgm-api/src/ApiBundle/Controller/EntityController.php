<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EntityController
 *
 * @Route("/entities")
 */
class EntityController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/", name="entities_read")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $admin = $this->getRequestAuthorizedUser($request, 'Admin');
        if ($admin instanceof Entity) {
            $responseArr = array();
            $entities = $this->getDoctrine()->getRepository('ApiBundle:Entity')->findAll();
            /** @var Entity $entity */
            foreach ($entities as $entity) {
                $responseArr[] = array(
                    'id' => $entity->getId(),
                    'name' => $entity->getName(),
                    'email' => $entity->getEmail(),
                    'identifier' => $entity->getIdentifier(),
                    'role' => $entity->getType(),
                    'createdAt' => $entity->getCreatedAt()->getTimestamp(),
                );
            }

            return $this->createStandardJsonResponse($responseArr);
        }

        return $this->createStandardJsonResponse(JsonResponse::HTTP_UNAUTHORIZED);
    }
}