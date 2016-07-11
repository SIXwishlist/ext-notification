<?php
// Copyright 1999-2016. Parallels IP Holdings GmbH.
class IndexController extends pm_Controller_Action
{
    public function indexAction()
    {
        $notifications = Modules_NotificationExample_Notification::getList();
        $form = new pm_Form_Simple();
        $subForm = new pm_Form_SubForm();
        $form->addElement('description', 'overall', [
            'description' => "Notification's settings could be changed in an extension hook (default settings) or via Tools and Settings -> Notifications.",
        ]);
        $subForm->setLegend('List of available notifications:');
        if (empty($notifications)) {
            $subForm->addElement('description', 'description', [
                'description' => 'There are no notifications provided by this extension.',
            ]);
        } else {
            foreach ($notifications as $id => $notification) {
                $subForm->addElement('description', $id, [
                    'description' => $notification['title'],
                ]);
            }
        }
        $form->addSubForm($subForm, 'list');
        $this->view->form = $form;
    }

    public function clientAction()
    {
        $client = pm_Session::getCurrentDomain()->getClient();
        $notifications = [];
        if ($client->isAdmin()) {
            $notifications = $this->_getFilteredNotifications('notifyAdmin');
        } elseif ($client->isReseller()) {
            $notifications = $this->_getFilteredNotifications('notifyResellers');
        } elseif ($client->isClient()) {
            $notifications = $this->_getFilteredNotifications('notifyClients');
        }

        if (empty($notifications)) {
            $this->_status->addMessage('error', 'There are no available notifications to send to the ' . $client->getProperty('email'));
        } else {
            $notificationManager = new pm_Notification();
            $allRecipients = [];
            foreach ($notifications as $id) {
                $recipients = $notificationManager->send(
                    $id,
                    [
                        'subject-text' => 'Custom Subject Info',
                        'message-text' => 'Custom Message Info',
                    ],
                    $client
                );
                $allRecipients = array_merge($allRecipients, $recipients);
            }
            foreach ($allRecipients as $recipient) {
                $this->_status->addMessage('info', 'Notifications are sent to ' . $recipient);
            }
        }
        $this->redirect(
            $this->view->domainOverviewUrl(pm_Session::getCurrentDomain()),
            ['prependBase' => false]
        );
    }

    /**
     * @param string $key
     * @return array
     */
    private function _getFilteredNotifications($key)
    {
        $client = pm_Session::getCurrentDomain()->getClient();
        if ($client->isAdmin()) {
            $key = 'notifyAdmin';
        } elseif ($client->isReseller()) {
            $key = 'notifyResellers';
        } elseif ($client->isClient()) {
            $key = 'notifyClients';
        }

        $notifications = array_filter(
            Modules_NotificationExample_Notification::getList()
            , function($item) use ($key) { return $item[$key]; }
        );
        return array_keys($notifications);
    }
}
