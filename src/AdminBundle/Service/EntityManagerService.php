<?php

/**
 * Written by Michał Turemka <michal.turemka@gmail.com>
 */

namespace AdminBundle\Service;

use Symfony\Component\HttpFoundation\Response;

class EntityManagerService {
    
    private $doctrine;
    private $entityClassName;

    public function __construct($doctrine) {
        $this->doctrine = $doctrine;
    }
    
    public function setEntityClassName($entityClassName) {
        $this->entityClassName = $entityClassName;
    }

    public function deleteOne($condition, $conditionName) {
        $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        $entity = $this->doctrine->getRepository($this->entityClassName)->findOneBy(array($conditionName => $condition));
        if(null != $entity) {
            $em = $this->doctrine->getManager();
            $em->remove($entity);
            $em->flush();
            $responseCode = Response::OK;
        }
        return $responseCode;
    }

}
