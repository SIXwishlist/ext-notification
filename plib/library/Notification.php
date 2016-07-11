<?php
// Copyright 1999-2016. Parallels IP Holdings GmbH.
class Modules_NotificationExample_Notification
{
    /**
     * Returns default notification's settings.
     * If some setting value is false it could be skipped here.
     * If some setting value is empty string it could be skipped here.
     *
     * @return array
     */
    public static function getDefaults()
    {
        return [
            'admin_notification' => [
                'notifyAdmin' => true,
                'notifyResellers' => false,
                'notifyClients' => false,
                'notifyCustomEmail' => false,
                'customEmail' => '',
                'subject' => 'Admin notification subject. <subject-text>',
                'message' => 'Admin notification text. <message-text>',
                'title' => "Admin's example notification",
            ],
            'reseller_notification' => [
                'notifyAdmin' => false,
                'notifyResellers' => true,
                'notifyClients' => false,
                'notifyCustomEmail' => false,
                'customEmail' => '',
                'subject' => 'Reseller notification subject. <subject-text>',
                'message' => 'Reseller notification text. <message-text>',
                'title' => "Reseller's example notification",
            ],
            'client_notification' => [
                'notifyAdmin' => false,
                'notifyResellers' => false,
                'notifyClients' => true,
                'notifyCustomEmail' => false,
                'customEmail' => '',
                'subject' => 'Client notification subject. <subject-text>',
                'message' => 'Client notification text. <message-text>',
                'title' => "Client's example notification",
            ],
        ];
    }

    /**
     * @return array
     */
    public static function getList()
    {
        $result = [];
        foreach (static::getDefaults() as $id => $notification) {
            $fullId = 'ext-' . pm_Context::getModuleId() . '-notification-' . $id;
            $settings = json_decode(\pm_Settings::get($fullId, '[]'), true);
            $result[$id] = array_merge($notification, $settings);
        }
        return $result;
    }
}
