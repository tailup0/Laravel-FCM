<?php

namespace LaravelFCM\Request;

/**
 * Class TopicGroupRequest.
 */
class TopicGroupRequest extends BaseRequest
{
    /**
     * @internal
     *
     * @var string
     */
    protected $notificationTopicName;

    /**
     * @internal
     *
     * @var array
     */
    protected $registrationIds;

    /**
     * GroupRequest constructor.
     *
     * @param $notificationTopicName
     * @param $registrationIds
     */
    public function __construct($notificationTopicName, $registrationIds)
    {
        parent::__construct();

        $this->notificationTopicName = $notificationTopicName;
        $this->registrationIds = $registrationIds;
    }

    /**
     * Build the header for the request.
     *
     * @return array
     */
    protected function buildBody()
    {
        return [
            'to' => $this->notificationTopicName,
            'registration_tokens' => $this->registrationIds,
        ];
    }
}
