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
     */
    public function indexAction(Request $request)
    {
        $admin = $this->getRequestAuthorizedUser($request, 'Admin');
        if ($admin instanceof Entity) {
            $entities = $this->getDoctrine()->getRepository('ApiBundle:Entity')->getAllButAdmin();
            return $this->createStandardJsonResponse($entities);
        }

        return $this->createStandardJsonResponse(JsonResponse::HTTP_UNAUTHORIZED);
    }
}