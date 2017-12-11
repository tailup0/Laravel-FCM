<?php

namespace LaravelFCM\Request;

/**
 * Class TopicInfoRequest.
 */
class TopicInfoRequest extends BaseRequest
{
    /**
     * TopicInfoRequest constructor.
     *
     * @param $notificationTopicName
     * @param $registrationIds
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Build the header for the request.
     *
     * @return array
     */
    protected function buildBody()
    {
        return [];
    }

    /**
     * Return the request in array form.
     *
     * @return array
     */
    public function build()
    {
        return [
            'headers' => $this->buildRequestHeader(),
            'query' => ['details' => 'true'],
        ];
    }
}
