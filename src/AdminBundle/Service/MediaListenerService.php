<?php
/**
 * Written by Michał Turemka <michal.turemka@gmail.com>
 */

namespace AdminBundle\Service;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Vich\UploaderBundle\Event as VichEvent;

class MediaListenerService implements EventSubscriberInterface {

    private $imagineController;
    private $imagineFilterConfiguration;

    public function __construct($imagineController, $imagineFilterConfiguration) {
        $this->imagineController = $imagineController;
        $this->imagineFilterConfiguration = $imagineFilterConfiguration;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents() {
        return [
            VichEvent\Events::POST_UPLOAD => 'postUpload'
        ];
    }

    /**
     * @param VichEvent\Event $event
     */
    public function postUpload(VichEvent\Event $event) {
        $this->createCache($event->getObject()->getName());
    }

    /**
     * @param $name
     */
    private function createCache($name) {
        $path = 'media/' . $name;
        $filters = array_keys($this->imagineFilterConfiguration->all());
        foreach ($filters as $filter) {
            $this->imagineController->filterAction(new Request(), $path, $filter);
        }
    }
}
