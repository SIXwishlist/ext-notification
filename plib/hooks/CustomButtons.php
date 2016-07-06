<?php
// Copyright 1999-2016. Parallels IP Holdings GmbH.
class Modules_NotificationExample_CustomButtons extends pm_Hook_CustomButtons
{
    public function getButtons()
    {
        return [
            [
                'place' => self::PLACE_DOMAIN,
                'title' => 'Send example notification to me',
                'description' => 'Send example notification to me',
                'link' => pm_Context::getActionUrl('index', 'client'),
            ]
        ];
    }

}
