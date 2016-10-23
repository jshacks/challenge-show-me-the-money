<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Entity;
use ApiBundle\Service\EntityService;
use ApiBundle\Service\NotifierService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class NotifierController
 * @Route("/notifiers")
 */
class NotifierController extends BaseController
{
    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     *
     * @Route("/{id}", name="notifiers_read_general", requirements={"id": "\d+"})
     */
    public function indexAction(Request $request, $id)
    {
        $entity = $this->getRequestAuthorizedUser($request, 'Notifier');
        if ($entity instanceof Entity && EntityService::checkDiffObjectId($entity, $id)) {
            /** @var NotifierService $notifierService */
            $notifierService = $this->get('notifier_service');
            $debtors = $notifierService->getNotifierFormatted($entity);

            return $this->createStandardJsonResponse($debtors);
        }

        return $this->createStandardJsonResponse(JsonResponse::HTTP_UNAUTHORIZED);
    }}