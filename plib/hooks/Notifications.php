<?php
// Copyright 1999-2016. Parallels IP Holdings GmbH. All Rights Reserved.

class Modules_NotificationExample_Notifications extends pm_Hook_Notifications
{
    public function getNotifications()
    {
        return Modules_NotificationExample_Notification::getDefaults();
    }
}
