<?php
require_once '../libs/AltoRouter.php';
include_once '../app/Controllers/UserController.php';

include_once 'router.php';

// Define route arrays for each controller
$routes = [];

// UserController routes
$routes['UserController'] = [
    ['GET', '/login', 'loginForm', 'login'],  // 'login' is the route name
    ['POST', '/login', 'login', 'login_post'],  // 'login_post' is the route name
    ['GET', '/logout', 'logout', 'logout']
];

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    // Check if the user is an admin
    if ($_SESSION['user']['role'] == 'admin') {
        // AdminController routes
        $routes['AdminController'] = [
            ['GET', '/', 'index', 'home'],
            ['GET|POST', '/ManageAdmins', 'manage_admins', 'manage_admins'],
        ];

        $routes['DocumentController'] = [
            ['GET', '/ViewPDF_[i:id]', 'view', 'view']
        ];

        // SupervisorController routes for admin
        $routes['SupervisorController'] = [
            ['GET', '/ManageSupervisors', 'manage_supervisors', 'manage_supervisors'],
            ['POST', '/AddSupervisor', 'add_supervisor', 'add_supervisor']
        ];

        $routes['StudentController'] = [
            ['GET', '/ManageStudents', 'manage_students', 'manage_students'],
            ['POST', '/AddStudent', 'add_student', 'add_student']
        ];
        $routes['ProjectController'] = [
            ['GET', '/UnapprovedProjects', 'unapproved', 'unapproved_projects'],
            ['POST', '/ApproveProject', 'approve', 'approve_project'],
            ['GET','/Projects','projects','projects'],
            
            ['GET', '/Project_[i:id]', 'show', 'project']
        ];

        $routes['MilestoneController'] = [
            ['GET', '/Milestones','index','milestones'],
            ['POST','/Milestones','store','store_milestone'],
            ['POST','/UpdateMilestone','update','update_milestone'],
            ['POST','/DeleteMilestone','delete','delete_milestone']

        ];
        $routes['SubMilestoneController'] = [
            ['GET', '/GradingCriteria', 'index', 'grading_criteria'],
            ['POST','/GradingCriteria','store','store_criteria'],
            ['POST','/UpdateSubMilestone','update','update_submilestone'],
            ['POST','/DeleteSubMilestone','delete','delete_submilestone']
        ];

        $routes['GradeController'] = [
            ['POST', '/GradeSubmission', 'submit_grades', 'submit_grades']
        ];
  
    }
    // Check if the user is a supervisor 
    elseif ($_SESSION['user']['role'] == 'supervisor') {

        // SupervisorController routes for supervisor
        $routes['SupervisorController'] = [
            ['GET', '/', 'index', 'home'],
            ['GET', '/ManageSupervisors', 'manage_supervisors', 'manage_supervisors'],
            ['GET', '/ManageStudents', 'manage_students', 'manage_students'],
            ['POST', '/AddStudent', 'add_student', 'add_student']
        ];

        // ProjectController routes for supervisor
        $routes['ProjectController'] = [
            ['GET', '/UnapprovedProjects', 'unapproved', 'unapproved_projects'],
            ['POST', '/ApproveProject', 'approve', 'approve_project'],
            ['GET','/Projects','projects','projects'],
            ['GET', '/Project_[i:id]', 'show', 'project']
        ];
        $routes['DocumentController'] = [
            ['GET', '/ViewPDF_[i:id]', 'view', 'view']
        ];
          $routes['NoteController'] = [
            ['POST', '/SaveNote', 'save', 'save_note']
            
        ];
        $routes['GradeController'] = [
            ['POST', '/GradeSubmission', 'save', 'submit_grades']
        ];
        $routes['MilestoneController'] = [
            ['GET', '/Project_[a:milestone_short]', 'showmilestone', 'supervisor_milestone']
        ];
     

    }
    // Routes for other users
    elseif ($_SESSION['user']['role'] == 'student') {
        // StudentController routes for other users
        $routes['StudentController'] = [
            ['GET', '/', 'index', 'home']
        ];
        $routes['ProjectController'] = [
            ['GET', '/RegisterProject', 'create', 'register_form'],
            ['POST', '/RegisterProject', 'store', 'register_project']
         
        ];
        $routes['MilestoneController'] = [
            ['GET', '/Project_[a:milestone_short]', 'show', 'student_milestone']
        ];
        $routes['DocumentController'] = [
            ['POST', '/UploadDocument', 'upload', 'upload_document'],
            ['GET', '/ViewPDF_[i:id]', 'view', 'view']

        ];
        
        $routes['NoteController'] = [
            ['POST', '/SaveNote', 'save', 'save_note'],
            ['POST','/MarkNote','mark','mark_note']
        ];
        
        
    }
}

// Register routes dynamically with names
foreach ($routes as $controller => $methods) {
    // Each method array contains: [HTTP method, URL path, controller action, route name]
    foreach ($methods as [$method, $path, $action, $name]) {
        $router->map($method, $path, ['controller' => $controller, 'action' => $action], $name);
    }
}

// Return the router instance
return $router;
