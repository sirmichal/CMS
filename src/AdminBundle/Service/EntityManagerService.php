<?php

/**
 * Written by Michał Turemka <michal.turemka@gmail.com>
 */

namespace AdminBundle\Service;

class EntityManagerService {
    
    private $doctrine;
    private $entityClassName;

    public function __construct($doctrine) {
        $this->doctrine = $doctrine;
    }
    
    public function setEntityClassName($entityClassName) {
        $this->entityClassName = $entityClassName;
    }

    public function delete($id) {
        $success = false;
        $entity = $this->doctrine->getRepository($this->entityClassName)->findOneById($id);
        if(null != $entity) {
            $em = $this->doctrine->getManager();
            $em->remove($entity);
//            $em->flush();
            $success = true;
        }
        return $success;
    }

}
