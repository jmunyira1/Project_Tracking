<?php require '../app/Views/header.php'; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        Projects
    </div>

    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>student reg no</th>
                        <th>student course</th>
                        <th>project title</th>
                        <th>Progress</th>

                        <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                            <th>Supervisor</th>
                        <?php endif; ?>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td><?php echo $project['student_reg_no']; ?></td>
                            <td><?php echo $project['course']; ?></td>
                            <td><?php echo $project['title']; ?></td>

                            <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                                <td><?php echo $project['supervisor_name']; ?></td>
                            <?php endif; ?>
                            <td>

                                <div class="progress" style="height: 15px">
                                    <div class="progress-bar" role="progressbar" style="width: <?= $project['progress'] ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <?php echo $project['progress']; ?>%
                                    </div>
                                </div>


                            </td>
                            <td>
                                <a href="<?= $this->router->generate('project', ['id' => $project['project_id']]) ?>" class="btn btn-outline-info">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php require '../app/Views/footer.php'; ?>