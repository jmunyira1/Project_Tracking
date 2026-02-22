<?php
include '../app/Views/header.php'; ?>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">Add Student</button>
  </div>

  <div class="card-body">
    <div class="table-responsive text-nowrap">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>UserName</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Reg Number</th>
            <th>Course</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($students as $student): ?>
            <tr>
              <td><?php echo $student['username']; ?></td>
              <td><?php echo $student['email']; ?></td>
              <td><?php echo $student['phone']; ?></td>
              <td><?php echo $student['reg_number']; ?></td>
              <td><?php echo $student['course']; ?></td>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
  <div class="offcanvas-header border-bottom">
    <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add Student</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body mx-0 flex-grow-0 h-100">
    <form class="add-new-user pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="addNewUserForm" method="POST" action="<?php if ($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'supervisor') {
                                                                                                                            echo $this->router->generate('add_student');
                                                                                                                          } ?>">
      <div class="form-floating form-floating-outline mb-5 fv-plugins-icon-container">
        <input type="text" class="form-control" id="username" name="username">
        <label for="username">Full Name</label>
      </div>
      <div class="form-floating form-floating-outline mb-5 fv-plugins-icon-container">
        <select id="gender" class="form-control" name="gender" required>
          <option value="" disabled selected>Select Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
        <label for="gender">Gender</label>
      </div>
      <div class="form-floating form-floating-outline mb-5">
        <input type="text" id="phone" class="form-control phone-mask" name="phone">
        <label for="phone">Contact</label>
      </div>
      <div class="form-floating form-floating-outline mb-5">
        <input type="text" id="reg_number" class="form-control" name="reg_number">
        <label for="reg_number">Registration Number</label>
      </div>
      <div class="form-floating form-floating-outline mb-5">
        <select id="course" class="form-control" name="course" required>
          <option value="" disabled selected>Select Course</option>
          <?php foreach ($courses as $c): ?>
            <option value="<?php echo $c['id']; ?>"><?php echo $c['code']; ?></option>
          <?php endforeach; ?>
        </select>
        <label for="course">Course</label>
      </div>
      <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit waves-effect waves-light">Submit</button>
      <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="offcanvas">Cancel</button>
    </form>
  </div>
</div>

<?php include '../app/Views/footer.php'; ?>