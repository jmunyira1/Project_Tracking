<!-- Menu -->
<?php
require_once '../app/Models/MilestoneModel.php';
require_once '../app/Models/ProjectModel.php';
$milestoneModel = new MilestoneModel();
$milestones = $milestoneModel->selectAll();
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Page -->
    <li class="menu-item active">
      <a href="<?= $this->router->generate('home'); ?>" class="menu-link">
        <i class="menu-icon tf-icons ri-home-smile-line"></i>
        <div data-i18n="Dashboard">Dashboard</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle waves-effect">
        <i class="menu-icon tf-icons ri-layout-2-line"></i>
        <div data-i18n="Project">Project</div>
      </a>

      <ul class="menu-sub">

        <?php 
        $projectcheck = new ProjectModel();
        $projectcheck = $projectcheck->selectAll('student_id = ' . $_SESSION['user']['id'] . ' AND status != "Pending"');
        $projectcheck = $projectcheck ? $projectcheck[0] : null;
        if ($projectcheck): ?>

          <li class="menu-item">
            <a href="" class="menu-link menu-toggle waves-effect">
              <div data-i18n="Milestones">Milestones</div>
            </a>
            <ul class="menu-sub">
              <?php foreach ($milestones as $milestone) : ?>
                <li class="menu-item">
                  <a href="<?= $this->router->generate('student_milestone', ['milestone_short' => $milestone['short']]); ?>" class="menu-link">
                    <div data-i18n="<?= $milestone['title']; ?>"><?= $milestone['title']; ?></div>
                  </a>
                </li>
              <?php endforeach; ?>

            </ul>
          </li>
          <li class="menu-item">
            <a href="<?= $this->router->generate('view'); ?>" class="menu-link">
              <div data-i18n="View">View</div>
            </a>
          </li>
        <?php endif; ?>
        <?php
        $projectcheck= new ProjectModel();
        $projectcheck = $projectcheck->selectAll('student_id = ' . $_SESSION['user']['id'] );
        $projectcheck = $projectcheck ? $projectcheck[0] : null;
        if (!$projectcheck): ?>
        
        <li class="menu-item">
            <a href="<?= $this->router->generate('register_project'); ?>" class="menu-link">
              <div data-i18n="Register">Register</div>
            </a>
          </li>
        <?php endif; ?>


      </ul>
    </li>
  </ul>
</aside>
<!-- / Menu -->