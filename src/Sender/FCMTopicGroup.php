<?php

namespace LaravelFCM\Sender;

use LaravelFCM\Request\Request;
use LaravelFCM\Request\TopicGroupRequest;
use LaravelFCM\Response\TopicGroupResponse;
use GuzzleHttp\Exception\ClientException;

/**
 * Class FCMTopicGroup.
 */
class FCMTopicGroup extends HTTPSender
{
    const MAX_TOKEN_PER_REQUEST = 1000;
    const ADD_URL_SUFFIX = ':batchAdd';
    const REMOVE_URL_SUFFIX = ':batchRemove';
    const TOPIC_PREFIX = '/topics/';

    /**
     * add tokens to topic.
     *
     * - an array of registrationIds
     *
     * @param string|null         $notificationTopicName
     * @param array|null         $registrationIds
     *
     * @return TopicGroupResponse|null
     */
    public function addTokensToTopic($notificationTopicName = null, $registrationIds = null)
    {
        $response = null;

        if (!empty($notificationTopicName) && !empty($registrationIds)) {
            $request = new TopicGroupRequest(self::TOPIC_PREFIX.$notificationTopicName, $registrationIds);

            $responseGuzzle = $this->post($request, self::ADD_URL_SUFFIX);

            $response = new TopicGroupResponse($responseGuzzle, $registrationIds);
        }

        return $response;
    }

    /**
     * remove tokens from topic.
     *
     * - an array of registrationIds
     *
     * @param string|null         $notificationTopicName
     * @param array|null         $registrationIds
     *
     * @return TopicGroupResponse|null
     */
    public function removeTokensFromTopic($notificationTopicName = null, $registrationIds = null)
    {
        $response = null;

        if (!empty($notificationTopicName) && !empty($registrationIds)) {
            $request = new TopicGroupRequest(self::TOPIC_PREFIX.$notificationTopicName, $registrationIds);

            $responseGuzzle = $this->post($request, self::REMOVE_URL_SUFFIX);

            $response = new TopicGroupResponse($responseGuzzle, $registrationIds);
        }

        return $response;
    }

    /**
     * @internal
     *
     * @param \LaravelFCM\Request\Request $request
     * @param string|"" $addUrl
     *
     * @return null|\Psr\Http\Message\ResponseInterface
     */
    private function post($request, $addUrl = "")
    {
        try {
            $responseGuzzle = $this->client->request('post', $this->url.$addUrl, $request->build());
        } catch (ClientException $e) {
            $responseGuzzle = $e->getResponse();
        }

        return $responseGuzzle;
    }
}
