<?php

namespace User;

use User\Listener\SendRecoverPasswordListener;
use Zend\EventManager\EventInterface;
use User\Listener\SendRegisterListener;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;

class Module implements BootstrapListenerInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(EventInterface $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $serviceManager = $e->getApplication()->getServiceManager();

        (new SendRegisterListener($serviceManager))->attach($eventManager, 100);
        (new SendRecoverPasswordListener($serviceManager))->attach($eventManager, 100);
    }
}
