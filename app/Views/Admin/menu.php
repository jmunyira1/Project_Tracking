<!-- Menu -->
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
            <div data-i18n="My Projects">Projects</div>
          </a>
        </li>

        <li class="menu-item">
          <a href="<?= $this->router->generate('milestones'); ?>" class="menu-link">
            <div data-i18n="Milestones">Milestones</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= $this->router->generate('grading_criteria'); ?>" class="menu-link">
            
            <div data-i18n="Grading">grading criteria</div>
          </a>
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
          <a href="<?= $this->router->generate('manage_admins'); ?>" class="menu-link">
            <div data-i18n="Admins">Admins</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= $this->router->generate('manage_supervisors'); ?>" class="menu-link">
            <div data-i18n="Supervisors">Supervisors</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= $this->router->generate('manage_students'); ?>" class="menu-link">
            <div data-i18n="Students">Students</div>
          </a>
        </li>

      </ul>
    </li>
  </ul>
</aside>
<!-- / Menu -->