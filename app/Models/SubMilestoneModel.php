<?php
require_once 'BaseModel.php';

class SubMilestoneModel extends BaseModel {
    public function __construct() {
        // Pass the table name 'courses' to the parent constructor
        parent::__construct('submilestones');
    }

}
