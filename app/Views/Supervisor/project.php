<?php include '../app/Views/header.php'; ?>

<div class="container py-3">
    <div class="card mb-3 shadow-sm">
        <div class="card-body">

            <div class="row">
                <div class="col-auto">
                    <h5 class="mb-1"><?= htmlspecialchars($project['title']) ?></h5>
                    <p class="mb-2 text-muted"><?= htmlspecialchars($project['description']) ?></p>
                    <span class="badge bg-primary">Status: <?= htmlspecialchars($project['status']) ?></span>
                </div>
                <div class="col text-end">
                    <h6 class="mb-1">Student</h6>
                    <p class="mb-0"><?= htmlspecialchars($project['student_name']) ?></p>
                    <p class="mb-0 text-muted"><?= htmlspecialchars($project['student_email']) ?></p>
                    <p class="mb-0 text-muted"><?= htmlspecialchars($project['student_reg_no']) ?></p>
                    <p class="mb-0 text-muted"><?= htmlspecialchars($project['course']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h6 class="mb-2">Progress</h6>
            <div class="progress" style="height: 10px;">
                <div class="progress-bar" role="progressbar" style="width: <?= htmlspecialchars($progress) ?>%;" aria-valuenow="<?= htmlspecialchars($progress) ?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="text-muted"><?= htmlspecialchars($progress) ?>% completed</small>
        </div>
    </div>

    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h6 class="mb-3">Milestones</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Milestone</th>
                            <th>Version</th>
                            <th>Grade</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($latestDocuments)): ?>
                            <tr>
                                <td colspan="4" class="text-center">No documents submitted yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($latestDocuments as $doc): ?>
                                <tr>
                                    <td><?= htmlspecialchars($doc['short']); ?><?=isset($doc['total_grade']) ?'<span class="badge bg-label-success">Graded</span>':'<span class="badge bg-label-danger">Ungraded</span>';?></td>
                                    <td>v<?= htmlspecialchars($doc['version']); ?></td>
                                    <td>
                                        <?php
                                        // Display the grade, formatted to 2 decimal places, or 'Not Graded' if NULL
                                        echo isset($doc['total_grade']) ? htmlspecialchars(number_format((float)$doc['total_grade'], 2)) : 'Not Graded';
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?= $this->router->generate('view', ['id' => $doc['id']]); ?>" class="btn btn-sm btn-primary">View</a>
                                        <?php
                                        // Check if there are older documents specifically for this milestone
                                        $hasOlder = false;
                                        if (!empty($olderDocuments)) {
                                            foreach ($olderDocuments as $oldDocCheck) {
                                                if ($oldDocCheck['milestone_id'] == $doc['milestone_id']) {
                                                    $hasOlder = true;
                                                    break;
                                                }
                                            }
                                        }
                                        if ($hasOlder):
                                        ?>
                                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_<?= htmlspecialchars($doc['milestone_id']); ?>">Older</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php if ($hasOlder): // Only render collapse structure if older versions exist for this milestone 
                                ?>
                                    <tr class="collapse" id="collapse_<?= htmlspecialchars($doc['milestone_id']); ?>">
                                        <td colspan="4">
                                            <div class="p-2">
                                                <h6 class="text-muted small mb-2">Older Versions:</h6>
                                                <table class="table table-sm table-bordered">
                                                    <tbody>
                                                        <?php foreach ($olderDocuments as $oldDoc): ?>
                                                            <?php if ($oldDoc['milestone_id'] == $doc['milestone_id']): ?>
                                                                <tr>
                                                                    <td><?= htmlspecialchars($oldDoc['short']); ?></td>
                                                                    <td>v<?= htmlspecialchars($oldDoc['version']); ?></td>
                                                                    <td></td>
                                                                    <td>
                                                                        <a href="<?= $this->router->generate('view', ['id' => $oldDoc['id']]); ?>" class="btn btn-sm btn-outline-primary">View</a>
                                                                    </td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include '../app/Views/footer.php'; ?>