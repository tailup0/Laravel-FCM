<?php

namespace LaravelFCM\Facades;

use Illuminate\Support\Facades\Facade;

class FCMTopicGroup extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fcm.topicgroup';
    }
}
