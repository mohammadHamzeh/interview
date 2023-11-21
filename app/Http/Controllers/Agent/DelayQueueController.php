<?php

namespace App\Http\Controllers\Agent;

use App\Contracts\Repository\AgentRepository;
use App\Contracts\Repository\DelayQueueRepository;
use App\Exceptions\AgentHasPendingDelayedQueue;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\DelayQueueRequest;
use App\Http\Resources\DelayedOrderQueueResource;

class DelayQueueController extends Controller
{
    public function __construct(
        private readonly AgentRepository $agentRepository,
        private readonly DelayQueueRepository $delayQueueRepository
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function delayQueue(DelayQueueRequest $request): DelayedOrderQueueResource
    {
        $agentId = $request->getAgentId();

        //check agent is available
        $agentIsAvailable = $this->agentRepository->agentIsAvailable($agentId);

        throw_unless($agentIsAvailable, AgentHasPendingDelayedQueue::class);

        //get delayed order queue
        $delayedOrderQueue = $this->delayQueueRepository->getDelayedOrderQueue();

        //assigned agent_id to delayed order
        $this->delayQueueRepository->updateAgentId($delayedOrderQueue->id, $agentId);

        $delayedOrderQueue->load('agent');

        return DelayedOrderQueueResource::make($delayedOrderQueue);
    }
}
