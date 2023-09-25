<?php

class Controller
{
    public function view($view, $data = [])
    {
        // Check for view file
        if (file_exists('app/views/' . $view . '.php')) {
            require_once 'app/views/' . $view . '.php';
        } else {
            // View does not exist
            die('View does not exist');
        }
    }
    public function models($model)
    {
        if (file_exists('app/models/' . $model . '.php')) {
            require_once 'app/models/' . $model . '.php';
            return new $model;
        } else {
            die('Model does not exist');
        }
    }
}
