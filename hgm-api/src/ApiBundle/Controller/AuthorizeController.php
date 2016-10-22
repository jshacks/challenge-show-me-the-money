<?php

namespace ApiBundle\Controller;

use ApiBundle\Service\EntityService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthorizeController
 * @Route("/authorize")
 */
class AuthorizeController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/login", name="authorize_login")
     * @Method("POST")
     */
    public function loginAction(Request $request)
    {
        $rawContent = $request->getContent();
        $data = @json_decode($rawContent, true) ?: array();
        /** @var EntityService $entityService */
        $entityService = $this->get('entity_service');
        $responseArr = $entityService->authorize($data);

        if (!empty($responseArr)) {
            return new JsonResponse($responseArr);
        }

        return new JsonResponse(JsonResponse::HTTP_UNAUTHORIZED);
    }
}