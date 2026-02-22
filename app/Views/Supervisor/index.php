<?php include '../app/Views/header.php'; ?>

<div class="container mt-4">
  <h4 class="mb-4">Supervisor Dashboard</h4>

  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Approved Projects</h5>
          <h3><?php echo $totalProjects; ?></h3> <!-- Displaying the total approved projects -->
          <p class="card-text">View the list of approved projects.</p>
          <!-- Physical button for approved projects -->
          <a href="<?php echo $this->router->generate('projects'); ?>" class="btn btn-primary waves-effect waves-light">
            View Approved Projects
          </a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">UnApproved Projects</h5>
          <h3><?php echo $unapprovedProjects; ?></h3> <!-- Displaying the total unapproved projects -->
          <p class="card-text">View the list of unapproved projects.</p>
          <!-- Physical button for unapproved projects -->
          <a href="<?php echo $this->router->generate('unapproved_projects'); ?>" class="btn btn-warning waves-effect waves-light">
            View Unapproved Projects
          </a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Completed Projects</h5>
          <h3><?php echo $completedProjects; ?></h3>
        </div>
      </div>
    </div>

  </div>

</div>

<?php require '../app/Views/footer.php'; ?>
