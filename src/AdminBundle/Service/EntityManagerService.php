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
            $responseCode = Response::HTTP_OK;
        }
        return $responseCode;
    }
    
    public function persistOne($entity) {
        $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        $em = $this->doctrine->getManager();
        $em->persist($entity);
        $em->flush();
        if($entity->getId() != null) {
            $responseCode = Response::HTTP_OK;
        }
        return $responseCode;
    }
    
    public function findAll($limit = null, $offset = null) {
        $em = $this->doctrine->getManager();
        $dql = "SELECT ent FROM {$this->entityClassName} ent";
        $query = $em->createQuery($dql)->setFirstResult($offset)->setMaxResults($limit);
        $result = $query->getResult();
        return $result;
    }
    
}
