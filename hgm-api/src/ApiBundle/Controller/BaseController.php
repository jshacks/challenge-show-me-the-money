<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{
    private $apiKeyName = 'x-hgm-api-key';

    /**
     * @param Request $request
     * @param string $expectType
     * @return null|Entity
     */
    protected function getRequestAuthorizedUser(Request $request, $expectType = '')
    {
        $headers = $request->headers->all();
        $authToken = @$headers[$this->apiKeyName] ? $headers[$this->apiKeyName][0] : '';

        $user = $this->get('entity_service')->getAuthenticatedUser($authToken, $expectType);
        if ($user instanceof Entity) {
            return $user;
        }

        return null;
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function getJsonPostData(Request $request)
    {
        $rawContent = $request->getContent();
        return @json_decode($rawContent, true) ?: array();
    }

    /**
     * @param $resource
     * @return JsonResponse
     */
    protected function createStandardJsonResponse($resource)
    {
        $response = new JsonResponse($resource);
        //$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}