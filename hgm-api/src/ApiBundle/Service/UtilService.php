<?php

namespace ApiBundle\Service;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class UtilService
{
    /**
     * @param ConstraintViolationListInterface $violationList
     * @return array
     */
    public static function getViolationListAsArray(ConstraintViolationListInterface $violationList)
    {
        $errors = array();
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        /** @var ConstraintViolationInterface $violation */
        foreach ($violationList as $violation) {

            $violationPath = '[' . $violation->getPropertyPath() . ']';
            $updatedErrors = array_merge((array) $propertyAccessor->getValue($errors, $violationPath), array($violation->getMessage()));
            $propertyAccessor->setValue($errors, $violationPath, $updatedErrors);
        }

        return $errors;
    }
}