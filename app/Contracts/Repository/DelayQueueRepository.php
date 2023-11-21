<?php

namespace App\Contracts\Repository;

interface DelayQueueRepository extends Repository
{
    public function getDelayedOrderQueue();

    public function updateAgentId($id,$agentId);
}
