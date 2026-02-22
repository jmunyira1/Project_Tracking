<?php require '../app/Views/header.php'; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasAddMilestone">
            Add Milestone
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Order</th>
                    <th>Short Name</th>
                    <th>Title</th>
                    <th>Max Marks</th>
                    <th>Description</th>

                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($milestones as $milestone): ?>
                    <tr>
                        <td><?php echo $milestone['no']; ?></td>
                        <td><?php echo htmlspecialchars($milestone['short']); ?></td>
                        <td><?php echo htmlspecialchars($milestone['title']); ?></td>
                        <td><?php echo $milestone['max_marks']; ?></td>
                        <td><?php echo htmlspecialchars($milestone['description']); ?></td>

                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                    <i class="ri-more-2-line"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#editMilestoneModal<?= $milestone['id']; ?>">
                                        <i class="ri-pencil-line me-1"></i> Edit
                                    </button>
                                    <a class="dropdown-item text-danger"
                                       href="delete_milestone.php?id=<?php echo $milestone['id']; ?>"
                                       onclick="return confirm('Are you sure?');">
                                        <i class="ri-delete-bin-7-line me-1"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Edit Milestone Modal -->
                    <div class="modal fade" id="editMilestoneModal<?= $milestone['id']; ?>" tabindex="-1"
                         aria-labelledby="editMilestoneModalLabel<?= $milestone['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editMilestoneModalLabel<?= $milestone['id']; ?>">Edit
                                        Milestone</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editMilestoneForm<?= $milestone['id']; ?>" method="POST"
                                          action="<?= $this->router->generate('update_milestone'); ?>">
                                        <input type="hidden" name="id" value="<?= $milestone['id']; ?>">

                                        <div class="mb-3">
                                            <label for="short" class="form-label">Short Name</label>
                                            <input type="text" class="form-control" id="short" name="short"
                                                   value="<?= htmlspecialchars($milestone['short']); ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="title" class="form-label">Milestone Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                   value="<?= htmlspecialchars($milestone['title']); ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description"
                                                      name="description"><?= htmlspecialchars($milestone['description']); ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="order" class="form-label">Order</label>
                                            <input type="number" class="form-control" id="order" name="order"
                                                   value="<?= $milestone['no']; ?>" required min="1">
                                        </div>


                                        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Milestone Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddMilestone"
     aria-labelledby="offcanvasAddMilestoneLabel">
    <div class="offcanvas-header border-bottom">
        <h5 id="offcanvasAddMilestoneLabel" class="offcanvas-title">Add Milestone</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="addMilestoneForm" method="POST" action="<?= $this->router->generate('store_milestone'); ?>">
            <div class="mb-3">
                <label for="short" class="form-label">Short Name</label>
                <input type="text" class="form-control" id="short" name="short" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Milestone Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="order" class="form-label">Order</label>
                <input type="number" class="form-control" id="order" name="order" required min="1">
            </div>


            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
    </div>
</div>

<?php require '../app/Views/footer.php'; ?>
