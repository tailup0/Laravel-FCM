<?php

namespace LaravelFCM\Sender;

use LaravelFCM\Request\Request;
use LaravelFCM\Request\TopicGroupRequest;
use LaravelFCM\Request\TopicInfoRequest;
use LaravelFCM\Response\TopicGroupResponse;
use LaravelFCM\Response\TopicInfoResponse;
use GuzzleHttp\Exception\ClientException;
use Exception;

/**
 * Class FCMTopicGroup.
 */
class FCMTopicGroup extends HTTPSender
{
    const MAX_TOKEN_PER_REQUEST = 1000;
    const ADD_URL_SUFFIX = ':batchAdd';
    const REMOVE_URL_SUFFIX = ':batchRemove';
    const INFO_URL_SUFFIX = '/info/';
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

            try {
                $response = new TopicGroupResponse($responseGuzzle, $registrationIds);
            } catch (Exception $e) {
                $response = $e->getMessage();
            }
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

            try {
                $response = new TopicGroupResponse($responseGuzzle, $registrationIds);
            } catch (Exception $e) {
                $response = $e->getMessage();
            }
        }

        return $response;
    }

    /**
     * get info from token.
     *
     * - a string of registrationId
     *
     * @param string|null         $notificationTopicName
     * @param string|null         $registrationId
     *
     * @return TopicGroupResponse|null
     */
    public function getInfoFromToken($registrationId = null)
    {
        $response = null;

        if (!empty($registrationId)) {
            $request = new TopicInfoRequest();

            $responseGuzzle = $this->get($request, self::INFO_URL_SUFFIX.$registrationId);

            try {
                $response = new TopicInfoResponse($responseGuzzle);
            } catch (Exception $e) {
                $response = $e->getMessage();
            }
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

    /**
     * @internal
     *
     * @param \LaravelFCM\Request\Request $request
     * @param string|"" $addUrl
     *
     * @return null|\Psr\Http\Message\ResponseInterface
     */
    private function get($request, $addUrl = "")
    {
        try {
            $responseGuzzle = $this->client->request('get', $this->url.$addUrl, $request->build());
        } catch (ClientException $e) {
            $responseGuzzle = $e->getResponse();
        }

        return $responseGuzzle;
    }
}
