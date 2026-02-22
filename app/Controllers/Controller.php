<?php
include_once '../config/router.php';
class Controller
{
    // Reference to the router
    protected $router;

    // Constructor to initialize router
    public function __construct()
    {
        global $router;
        $this->router = $router;
    }
}