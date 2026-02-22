<?php include '../app/Views/header.php'; ?>

<h3>
    <strong><?= htmlspecialchars($xmilestone) ?>s</strong>
</h3>

<?php if (empty($projects)): ?>
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">No Projects Found</h4>
        <p>There are no documents submitted for this milestone.</p>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    
                <th>Project Title</th>
                <th>Reg. Number</th>
                    <th>Student Name</th>
                    
                    <th>Course</th>
                    <th>Version</th>
                    <th>Grade</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $project): ?>
                    <?php foreach ($project['documents'] as $document): ?>
                        <tr>
                        <td><?= htmlspecialchars($project['project_title']) ?>
                        <?= $document['grade'] !== null ? ' <span class="badge bg-label-success">Graded</span>' : ' <span class="badge bg-label-warning">Not Graded</span>' ?>
                       
                    
                    </td>
                        <td><?= htmlspecialchars($project['student_reg_no']) ?></td>
                            <td><?= htmlspecialchars($project['student_name']) ?></td>
                      
                            <td><?= htmlspecialchars($project['course']) ?></td>
                           
                            <td>v<?= htmlspecialchars($document['document_version']) ?></td>
                            <td><?= $document['grade'] !== null ? number_format($document['grade'], 2) : 'Not Graded' ?></td>
                            <td>
                                <a href="<?= $this->router->generate('view', ['id' => $document['document_id']]); ?>" class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include '../app/Views/footer.php'; ?>