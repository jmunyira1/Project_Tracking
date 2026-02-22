<?php require '../app/Views/header.php'; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        unapproved projects
    </div>

    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <?php if ($_SESSION['user']['role'] == 'admin') : ?>
                            <th>supervisor name</th>
                        <?php endif; ?>
                        <th>student reg no</th>
                        <th>student course</th>
                        <th>project title</th>
                        <th>project description</th>
                    
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <?php if ($_SESSION['user']['role'] == 'admin') : ?>
                                <td><?php echo $project['supervisor_name']; ?></td>
                            <?php endif; ?>
                            <td><?php echo $project['student_reg_no']; ?></td>
                            <td><?php echo $project['course']; ?></td>
                            <td><?php echo $project['title']; ?></td>
                            <td><?php echo $project['description']; ?></td>
                            <td>
                                <form action="<?= $this->router->generate('approve_project'); ?>" method="post">
                                    <input type="hidden" name="project_id" value="<?php echo $project['project_id']; ?>">
                                    <button type="submit" class="btn btn-success">Approve</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php require '../app/Views/footer.php'; ?>