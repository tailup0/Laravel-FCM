<?php

namespace LaravelFCM\Response;

/**
 * Interface TopicGroupResponseContract.
 */
interface TopicGroupResponseContract
{
    /**
     * Get the results.
     *
     * @return array
     */
    public function results();

    /**
     * Get the error results.
     *
     * @return array
     */
    public function errorResults();

}
