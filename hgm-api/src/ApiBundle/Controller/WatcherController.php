<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Entity;
use ApiBundle\Service\EntityService;
use ApiBundle\Service\WatcherService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class WatcherController
 * @Route("/watchers")
 */
class WatcherController extends BaseController
{
    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     *
     * @Route("/{id}", name="watchers_read_general", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function indexAction(Request $request, $id)
    {
        $entity = $this->getRequestAuthorizedUser($request, 'Watcher');
        if ($entity instanceof Entity && EntityService::checkDiffObjectId($entity, $id)) {
            /** @var WatcherService $watcherService */
            $watcherService = $this->get('watcher_service');
            $debtors = $watcherService->getWatcherFormatted($entity);

            return $this->createStandardJsonResponse($debtors);
        }

        return $this->createStandardJsonResponse(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/debtors/save", name="watcher_debtors_save")
     * @Method("POST")
     */
    public function debtorsSaveAction(Request $request)
    {
        $entity = $this->getRequestAuthorizedUser($request, 'Watcher');
        if ($entity instanceof Entity) {
            $data = $this->getJsonPostData($request);
            /** @var WatcherService $watcherService */
            $watcherService = $this->get('watcher_service');

            $responseArr = $watcherService->save($data);
            return $this->createStandardJsonResponse($responseArr);
        }

        return $this->createStandardJsonResponse(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/debts/save", name="watchers_debts_save")
     * @Method("POST")
     */
    public function debtsSaveAction(Request $request)
    {
        $entity = $this->getRequestAuthorizedUser($request, 'Watcher');
        if ($entity instanceof Entity) {
            $data = $this->getJsonPostData($request);
            /** @var WatcherService $watcherService */
            $watcherService = $this->get('watcher_service');

            $responseArr = $watcherService->saveDebt($data, $entity);
            return $this->createStandardJsonResponse($responseArr);
        }

        return $this->createStandardJsonResponse(JsonResponse::HTTP_UNAUTHORIZED);
    }
}