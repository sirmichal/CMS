<?php

namespace AdminBundle\Service;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Vich\UploaderBundle\Event as VichEvent;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class MediaListenerService implements EventSubscriberInterface {
    
    private $kernel;
    
    public function __construct($kernel) {
        $this->kernel = $kernel;
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
    
    private function createCache($name) {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(array(
            'command' => 'liip:imagine:cache:resolve',
            'paths' => array('media/' . $name)
        ));

        $output = new NullOutput();
        $application->run($input, $output);
    }

}
