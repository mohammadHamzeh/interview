<?php

namespace App\Contracts\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface Repository
{
    public function find($id, ?array $with = []);

    public function all(?array $with = [], ?array $filters = [], ?array $select = []);

    public function create(array $data): Model|Builder;

    public function update(array $data, $id): ?Model;
}
