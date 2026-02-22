<?php
include '../app/Views/header.php';

?>

<?php if ($project): // Check if project data exists 
?>

    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 card-title"><?= htmlspecialchars($project['title']) ?></h5>
            <span class="badge bg-label-<?= $project['status'] === 'Approved' ? 'success' : ($project['status'] === 'Rejected' ? 'danger' : ($project['status'] === 'Completed' ? 'primary' : 'warning')) ?>">
                Status: <?= htmlspecialchars($project['status']) ?>
            </span>
        </div>
        <div class="card-body">
            <p class="card-text"><?= nl2br(htmlspecialchars($project['description'] ?? 'No description provided.')) ?></p>
            <hr class="my-3">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Supervisor:</strong></p>
                    <p><?= $project['supervisor_name'] ?></p>
                </div>

            </div>
            <?php if (isset($finalGrade) && $finalGrade !== null) : ?>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1">
                        <p>
                            <strong>Final Grade: <?= $finalGrade ?> </strong>
                        </p>
                        </p>

                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h6 class="mb-2">Project Progress</h6>
            <div class="progress" style="height: 10px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: <?= htmlspecialchars($progress) ?>%;" aria-valuenow="<?= htmlspecialchars($progress) ?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="text-muted"><?= htmlspecialchars($progress) ?>% completed</small>
        </div>
    </div>

<?php else: // Display message if no project is found 
?>

    <div class="card mb-4 shadow-sm">
        <div class="card-body text-center">
            <h5 class="card-title">No Project Found</h5>
            <p class="card-text">You currently do not have an active project registered in the system.</p>
            <a href="<?= $this->router->generate('register_form') ?>" class="btn btn-primary">Register a New Project</a>
        </div>
    </div>

<?php endif; ?>

<div class="card shadow-sm">
</div>

<?php include '../app/Views/footer.php'; ?>