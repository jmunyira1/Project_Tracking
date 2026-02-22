<?php require '../app/Views/header.php'; ?>
          

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Register Project</h5>
    </div>
    <div class="card-body">
        <form action="<?= $this->router->generate('register_project') ?>" method="POST">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ; ?>">
            <div class="row mb-4">
                <label class="col-sm-2 col-form-label" for="project-title">Project Title</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="project-title" name="title" placeholder="Enter project title" required>
                </div>
            </div>


            <div class="row mb-4">
                <label class="col-sm-2 col-form-label" for="supervisor">Supervisor</label>
                <div class="col-sm-10">
                    <select class="form-control" id="supervisor" name="supervisor_id" required>
                        <option value="">Select Supervisor</option>
                        <?php foreach ($supervisors as $supervisor): ?>
                            <option value="<?= $supervisor['id'] ?>"><?= $supervisor['username'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-4">
                <label class="col-sm-2 col-form-label" for="description">Description</label>
                <div class="col-sm-10">
                    <textarea id="description" class="form-control" name="description" placeholder="Provide a brief description" required></textarea>
                </div>
            </div>

            <div class="row justify-content-end">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Register Project</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require '../app/Views/footer.php'; ?>