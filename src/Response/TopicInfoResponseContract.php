<?php

namespace LaravelFCM\Response;

/**
 * Interface TopicInfoResponseContract.
 */
interface TopicInfoResponseContract
{
    /**
     * Get the results.
     *
     * @return array
     */
    public function results();

    /**
     * Get the topics.
     *
     * @return array
     */
    public function topics();

}
