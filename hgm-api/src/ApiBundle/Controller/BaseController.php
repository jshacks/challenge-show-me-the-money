<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{
    protected function getRequestDataSet(Request $request)
    {
        $dataSet = array(
            'user' => null,
            'data' => array(),
        );



        return $dataSet;
    }
}