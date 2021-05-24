<?php

namespace App\Models;

abstract class AbstractModel {

    private $data = [];

    public function __get($name) {
        return $this->data[$name];
    }

    public function __set($name, $value) {
        return $this->data[$name] = $value;
    }
}
