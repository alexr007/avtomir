<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 16.02.2017
 * Time: 10:05
 */
class SearchResults
{
    private $data;
    private $errors;

    public function __construct($data, $errors) {
        $this->data = $data;
        $this->errors = $errors;
    }

    public function data() {
        return $this->data;
    }

    public function errors() {
        return $this->errors;
    }

    public function hasData() {
        return $this->data->count > 0;
    }

    public function hasErrors() {
        return $this->errors->count > 0;
    }
}