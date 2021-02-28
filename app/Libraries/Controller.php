<?php

/**
 * Base Controller
 * Loads the modelss and views
 */
class Controller {

    /**
     * Load Model
     * @param $model
     */
    public function model($model) {
        //Require model file
        require_once '../app/models/' . $model . '.php';

        //Instatiate model
        return new $model();
    }

    /**
     * Load the view
     * @param $view
     * @param array $data
     */
    public function view($view, $data = [])
    {
        if(file_exists('../app/views/' . $view . '.php')) {

            require_once APPROOT . '/views/inc/header.php';

            require_once '../app/views/' . $view . '.php';

            require_once APPROOT . '/views/inc/footer.php';

        } else {
            require_once '../app/views/errors/error_404.php';
        }
    }
}