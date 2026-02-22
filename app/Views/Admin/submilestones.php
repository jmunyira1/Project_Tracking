<?php require '../app/Views/header.php'; ?>

<?php foreach ($milestones as $milestone): ?>
    <!-- Accordion for each Milestone -->
    <div class="accordion" id="accordionMilestone<?= $milestone['id']; ?>">
        <div class="accordion-item shadow-sm mb-4">
            <h2 class="accordion-header" id="heading<?= $milestone['id']; ?>">
                <button class="accordion-button d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $milestone['id']; ?>" aria-expanded="true" aria-controls="collapse<?= $milestone['id']; ?>">
                    <span><?= htmlspecialchars($milestone['title']); ?></span>
                    <span class="badge bg-secondary ms-2">Total Marks: <?= $milestone['max_marks']; ?></span>
                </button>
            </h2>

            <div id="collapse<?= $milestone['id']; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $milestone['id']; ?>" data-bs-parent="#accordionMilestone<?= $milestone['id']; ?>">
                <div class="accordion-body">
                    <!-- Submilestones Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Maximum Marks</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($submilestones as $submilestone): ?>
                                    <?php if ($submilestone['milestone_id'] == $milestone['id']): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($submilestone['name']); ?></td>
                                            <td><?= htmlspecialchars($submilestone['max_marks']); ?></td>
                                            <td class="text-center">
                                                <!-- Edit Button Trigger -->
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editSubmilestoneModal<?= $submilestone['id']; ?>">Edit</button>
                                                <a href="delete_submilestone.php?id=<?= $submilestone['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this submilestone?')">Delete</a>
                                            </td>
                                        </tr>

                                        <!-- Edit Submilestone Modal -->
                                        <div class="modal fade" id="editSubmilestoneModal<?= $submilestone['id']; ?>" tabindex="-1" aria-labelledby="editSubmilestoneModalLabel<?= $submilestone['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editSubmilestoneModalLabel<?= $submilestone['id']; ?>">Edit Submilestone</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action=" <?= $this->router->generate('update_submilestone'); ?> " method="POST">
                                                            <input type="hidden" name="id" value="<?= $submilestone['id']; ?>">
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Submilestone Name</label>
                                                                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($submilestone['name']); ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="max_marks" class="form-label">Maximum Marks</label>
                                                                <input type="number" class="form-control" id="max_marks" name="max_marks" value="<?= htmlspecialchars($submilestone['max_marks']); ?>" required>
                                                            </div>

                                                            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Button to Add Submilestone (Trigger Modal) -->
                    <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#addSubmilestoneModal<?= $milestone['id']; ?>">Add Submilestone</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Submilestone Modal -->
    <div class="modal fade" id="addSubmilestoneModal<?= $milestone['id']; ?>" tabindex="-1" aria-labelledby="addSubmilestoneModalLabel<?= $milestone['id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubmilestoneModalLabel<?= $milestone['id']; ?>">Add Submilestone</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= $this->router->generate('store_criteria'); ?>" method="POST">
                        <input type="hidden" name="milestone_id" value="<?= $milestone['id']; ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Submilestone Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="max_marks" class="form-label">Maximum Marks</label>
                            <input type="number" class="form-control" id="max_marks" name="max_marks" step="any" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Add Submilestone</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>


<?php require '../app/Views/footer.php'; ?>