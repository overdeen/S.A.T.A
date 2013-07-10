<?php

class Base_Controller extends Controller {

    public $restful = true;

    public function __construct() {
        require path('app') . 'libraries/htmlpurifier/library/HTMLPurifier.auto.php';
    }

    /**
     * Catch-all method for requests that can't be matched.
     *
     * @param  string    $method
     * @param  array     $parameters
     * @return Response
     */
    public function __call($method, $parameters) {
        return Response::error('404');
    }

}