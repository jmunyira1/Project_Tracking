<?php require '../app/Views/header.php'; ?>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5>Administrators</h5>
    <button type="submit" class="btn btn-outline-primary">Add Admin</button>
  </div>

  <div class="card-body">
    <div class="table-responsive text-nowrap">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>UserName</th>
            <th>Email</th>
            <th>Phone</th>

            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($admins as $admin): ?>
            <tr>
              <td><?php echo $admin['username']; ?></td>
              <td><?php echo $admin['email']; ?></td>
              <td><?php echo $admin['phone']; ?></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-more-2-line"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item waves-effect" href="javascript:void(0);"><i class="ri-pencil-line me-1"></i> Edit</a>
                    <a class="dropdown-item waves-effect" href="javascript:void(0);"><i class="ri-delete-bin-7-line me-1"></i> Delete</a>
                  </div>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include '../app/Views/footer.php'; ?>