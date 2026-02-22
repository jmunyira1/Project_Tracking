<?php
require_once 'BaseModel.php';

class GradeModel extends BaseModel {
    public function __construct() {
        // Pass the table name 'Grades' to the parent constructor
        parent::__construct('grades');
    }

}
