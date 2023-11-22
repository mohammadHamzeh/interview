<?php

namespace App\Http\Controllers\Agent;

use App\Contracts\Repository\AgentRepository;
use App\Contracts\Repository\DelayQueueRepository;
use App\Exceptions\AgentHasPendingDelayedQueue;
use App\Exceptions\DelayedQueueEmpty;
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
        throw_if(empty($delayedOrderQueue), DelayedQueueEmpty::class);

        //assigned agent_id to delayed order
        $delayedOrderQueue = $this->delayQueueRepository->updateAgentId($delayedOrderQueue->id, $agentId);

        $delayedOrderQueue->load(['order', 'agent']);

        return DelayedOrderQueueResource::make($delayedOrderQueue);
    }
}
