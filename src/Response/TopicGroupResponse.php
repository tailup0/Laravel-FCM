<?php

namespace LaravelFCM\Response;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Http\Message\ResponseInterface;

/**
 * Class TopicGroupResponse.
 */
class TopicGroupResponse extends BaseResponse implements TopicGroupResponseContract
{
    const RESULTS = 'results';

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
    protected $errorResults = [];

    /**
     * @internal
     *
     * @var array
     */
    protected $registrationIds = [];

    /**
     * TopicGroupResponse constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                $registrationIds
     */
    public function __construct(ResponseInterface $response, $registrationIds)
    {
        $this->registrationIds = $registrationIds;
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
        if (array_key_exists(self::RESULTS, $responseInJson)) {
            $this->results = $responseInJson[self::RESULTS];
        }

        foreach($this->results as $idx => $result) {
            if (array_key_exists(self::ERROR, $result)) {
                if (array_key_exists($idx, $this->registrationIds)) {
                    $this->errorResults[] = [
                        'id' => $this->registrationIds[$idx],
                        self::ERROR => $result[self::ERROR],
                    ];
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
     * Get the error results.
     *
     * @return array
     */
    public function errorResults()
    {
        return $this->errorResults;
    }
}
