<?php

namespace LaravelFCM\Response;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Http\Message\ResponseInterface;

/**
 * Class TopicInfoResponse.
 */
class TopicInfoResponse extends BaseResponse implements TopicInfoResponseContract
{
    const REL = 'rel';
    const TOPICS = 'topics';

    /**
     * @internal
     *
     * @var array
     */
    protected $results = [];

    /**
     * @internal
     *
     * @var array
     */
    protected $topics = [];

    /**
     * TopicGroupResponse constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                $registrationIds
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
    }

    /**
     * parse the response.
     *
     * @param $responseInJson
     */
    protected function parseResponse($responseInJson)
    {
        $this->parse($responseInJson);

        // if ($this->logEnabled) {
        //     $this->logResponse();
        // }
    }

    /**
     * Log the response.
     */
    protected function logResponse()
    {
        $logger = new Logger('Laravel-FCM');
        $logger->pushHandler(new StreamHandler(storage_path('logs/laravel-fcm.log')));

        $logger->info($logMessage);
    }

    /**
     * @internal
     *
     * @param $responseInJson
     *
     */
    private function parse($responseInJson)
    {
        if (array_key_exists(self::ERROR, $responseInJson)) {
        } else {
            $this->results = $responseInJson;
            if (array_key_exists(self::REL, $responseInJson)) {
                if (array_key_exists(self::TOPICS, $responseInJson[self::REL])) {
                    foreach($responseInJson[self::REL][self::TOPICS] as $topic => $value) {
                        $this->topics[] = $topic;
                    }
                }
            }
        }
    }

    /**
     * Get the results.
     *
     * @return array
     */
    public function results()
    {
        return $this->results;
    }

    /**
     * Get the topics.
     *
     * @return array
     */
    public function topics()
    {
        return $this->topics;
    }
}
