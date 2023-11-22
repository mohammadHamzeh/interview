<?php

namespace App\Repositories;

use App\Enums\DelayQueue\Status;
use App\Models\DelayQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DelayQueueRepository extends BaseRepository implements \App\Contracts\Repository\DelayQueueRepository
{
    protected function model(): string
    {
        return DelayQueue::class;
    }

    public function getDelayedOrderQueue(): Model|Builder|null
    {
        return $this->model
            ->with('order')
            ->where('status', Status::PENDING)
            ->whereNull('agent_id')
            ->oldest('id')
            ->first();
    }

    public function updateAgentId($id, $agentId): Model|Collection|Builder|array|null
    {
        $record = $this->model->query()->find($id);
        $record->lockForUpdate()->update([
            'agent_id' => $agentId
        ]);
        return $record->fresh();
    }
}
