<?php
include_once 'Controller.php';
require_once '../app/Models/CourseModel.php';

class CourseController extends Controller
{
    private $CourseModel;

    public function __construct()
    {
        parent::__construct();
        $this->CourseModel = new CourseModel();
    }
}
