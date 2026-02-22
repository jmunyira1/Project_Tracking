<?php require '../app/Views/header.php'; ?>
<div class="row">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Total Projects</h6>
                <h3><?= $totalProjects; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Pending Projects</h6>
                <h3><?= $pendingProjects; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Students</h6>
                <h3><?= $totalStudents; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Supervisors</h6>
                <h3><?= $totalSupervisors; ?></h3>
            </div>
        </div>
    </div>
</div>
<hr>
<h5 class="mt-4">Milestone Progress</h5>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Milestone</th>
      <th>Submitted</th>
      <th>Progress</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($milestoneProgress as $m): 
        $percent = $m['total_projects'] > 0 ? ($m['total_submitted'] / $m['total_projects']) * 100 : 0;
    ?>
      <tr>
        <td><?= $m['title']; ?></td>
        <td><?= $m['total_submitted']; ?>/<?= $m['total_projects']; ?></td>
        <td>
          <div class="progress" style="height: 20px;">
            <div class="progress-bar" role="progressbar" style="width: <?= $percent ?>%;" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100">
              <?= round($percent); ?>%
            </div>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require '../app/Views/footer.php'; ?>