<?php

namespace App\Contracts\Repository;

interface AgentRepository extends Repository
{
    public function agentIsAvailable($agentId);
}
