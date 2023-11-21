<?php

namespace App\Repositories;

use App\Contracts\Repository\Repository;
use App\Exceptions\Repository\InvalidException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements Repository
{
    protected Model $model;

    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * @throws InvalidException
     */
    protected function makeModel(): void
    {
        $model = app($this->model());
        if (!$model instanceof Model) {
            throw new InvalidException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        $this->model = $model;
    }


    public function find($id, ?array $with = []): Model|Collection|Builder|array|null
    {
        return $this->model
            ->with($with)
            ->findOrFail($id);
    }

    public function all(?array $with = [], ?array $filters = [], ?array $select = [])
    {
        $list = $this->model::query();
        if ($select) {
            $list = $list->select($select);
        }

        if ($filters) {
            foreach ($filters as $key => $value) {
                $list = $list->where($key, $value);
            }
        }

        return $list->with($with)->orderByDesc('created_at')->jsonPaginate();
    }

    public function update(array $data, $id): ?Model
    {
        $record = $this->find($id);
        $record->update($data);

        return $record;
    }

    public function create(array $data): Model|Builder
    {
        return $this->model->query()->create($data);
    }

    abstract protected function model(): string;

}
