<?php

namespace User\Listener;

use Core\Stdlib\CurrentUrl;
use Exception;
use User\Controller\IndexController;
use User\Mail\Mail;
use User\Model\UserTable;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceManager;

class SendRecoverPasswordListener extends AbstractListenerAggregate
{
    use CurrentUrl;

    private $serviceManager;

    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $sharedEvents = $events->getSharedManager();
        $this->listeners[] = $sharedEvents->attach(
            IndexController::class,
            'recoverPasswordAction.post',
            [$this, 'onSendRecoverPassaword'],
            $priority
        );
    }

    public function onSendRecoverPassaword(Event $event)
    {
        $controller = $event->getTarget();
        $email = $event->getParams()['data'];

        try {
            $userTable = $this->serviceManager->get(UserTable::class);
            $user = $userTable->getUserByEmail($email);

            $user = $userTable->save([
                'id' => $user->id,
                'email' => $user->email,
            ]);

            $transport = $this->serviceManager->get('core.transport.smtp');
            $view = $this->serviceManager->get('View');

            $data = $user->getArrayCopy();
            $data['ip'] = $controller->getRequest()->getServer('REMOTE_ADDR');
            $data['host'] = $this->getUrl($controller->getRequest());

            $email = new Mail($transport, $view, 'user/mail/recover-password');
            $email->setSubject('Nova senha, help desk ZF3 na prática')
                ->setTo(strtolower(trim($user->email)))
                ->setData($data)
                ->prepare()
                ->send();
        } catch (\Exception $exception) {
            echo $exception->getTraceAsString();
            die;
        }
    }
}
