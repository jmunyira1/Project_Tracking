<!-- Menu -->
<?php
require_once '../app/Models/MilestoneModel.php';
$milestoneModel = new MilestoneModel();
$milestones = $milestoneModel->selectAll();
?><!-- Menu -->
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
        <div data-i18n="Projects">Projects</div>
      </a>

      <ul class="menu-sub">
        <li class="menu-item">
          <a href="<?= $this->router->generate('projects'); ?>" class="menu-link">
            <div data-i18n="My Projects">My Projects</div>
          </a>
        </li>
        <li class="menu-item">
            <a href="" class="menu-link menu-toggle waves-effect">
              <div data-i18n="Milestones">Milestones</div>
            </a>
            <ul class="menu-sub">
              <?php foreach ($milestones as $milestone) : ?>
                <li class="menu-item">
                  <a href="<?= $this->router->generate('supervisor_milestone', ['milestone_short' => $milestone['short']]); ?>" class="menu-link">
                    <div data-i18n="<?= $milestone['title']; ?>"><?= $milestone['title']; ?></div>
                  </a>
                </li>
              <?php endforeach; ?>

            </ul>
          </li>


        <li class="menu-item">
          <a href="<?= $this->router->generate('unapproved_projects'); ?>" class="menu-link">
            <div data-i18n="Unapproved">Unapproved</div>
          </a>
        </li>

      </ul>
    </li>


    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle waves-effect">
        <i class="menu-icon tf-icons ri-layout-2-line"></i>
        <div data-i18n="Users">Users</div>
      </a>

      <ul class="menu-sub">
        <li class="menu-item">
          <a href="<?= $this->router->generate('manage_supervisors'); ?>" class="menu-link">
            <div data-i18n="Supervisors">Supervisors</div>
          </a>
        </li>

      </ul>
    </li>
  </ul>
</aside>
<!-- / Menu -->