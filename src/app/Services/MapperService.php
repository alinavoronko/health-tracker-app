<?php

namespace App\Services;

class MapperService
{

    public function modelMapper($model)
    {
        return function ($entry) use ($model) {
            return $this->mapper($model, $entry);
        };
    }

    public function mapper($model, $entry)
    {
        $friendRequest = new $model();

        foreach ($entry as $key => $value) {
            $friendRequest->$key = $value;
        }

        return $friendRequest;
    }

    public function toModel($collection, $model)
    {
        return $collection->map($this->modelMapper($model));
    }
}
