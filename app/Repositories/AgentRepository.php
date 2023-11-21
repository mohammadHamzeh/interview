<?php

namespace App\Repositories;

use App\Enums\DelayQueue\Status;
use App\Models\Agent;

class AgentRepository extends BaseRepository implements \App\Contracts\Repository\AgentRepository
{
    protected function model(): string
    {
        return Agent::class;
    }

    public function agentIsAvailable($agentId): bool
    {
        return $this->model->query()
            ->where('id', $agentId)
            ->whereDoesntHave('delayQueue', function ($query) {
                $query->where('status', Status::PENDING);
            })->exists();
    }
}
