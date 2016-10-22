<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Entity;
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
        $data = $this->getJsonPostData($request);
        /** @var EntityService $entityService */
        $entityService = $this->get('entity_service');
        $responseArr = $entityService->authorize($data);

        if (!empty($responseArr)) {
            return $this->createStandardJsonResponse($responseArr);
        }

        return $this->createStandardJsonResponse(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * For Admin only
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/register", name="authorize_register")
     * @Method("POST")
     */
    public function registerAction(Request $request)
    {
        $entity = $this->getRequestAuthorizedUser($request, 'Admin');
        if ($entity instanceof Entity) {
            $data = $this->getJsonPostData($request);
            /** @var EntityService $entityService */
            $entityService = $this->get('entity_service');
            $responseArr = $entityService->register($data);

            return $this->createStandardJsonResponse($responseArr);
        }

        return $this->createStandardJsonResponse(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/register/confirm", name="authorize_register_confirm")
     * @Method("PUT")
     */
    public function registerConfirmAction(Request $request)
    {
        $data = $this->getJsonPostData($request);
        /** @var EntityService $entityService */
        $entityService = $this->get('entity_service');

        $errors = $entityService->registerConfirm($data);
        if (!empty($errors)) {
            return $this->createStandardJsonResponse(array(
                'errors' => $errors,
            ));
        }

        return $this->createStandardJsonResponse(JsonResponse::HTTP_OK);
    }
}