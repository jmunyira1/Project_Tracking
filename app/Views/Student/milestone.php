<?php
include '../app/Views/header.php';
?>

<div class="card">
    <div class="card-header border">
        <h5><?php echo $current_milestone['title']; ?></h5>
        <p><?= $current_milestone['description'] ?></p>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-7">
                <div class="border p-2 mt-3">
                    <h5>Content Submitted</h5>
                    <?php if ($documents): ?>
                        <div class="table table-responsive">
                            <table class="table table-hover table-striped border">
                                <thead>
                                    <tr>
                                        <th>Version</th>
                                        <th>Date Uploaded</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($documents as $document): ?>
                                        <tr>
                                            <td>Proposal Document Version <?= $document['version']; ?></td>
                                            <td><?= $document['updated_at']; ?></td>
                                            <td>
                                                <a href="<?= $this->router->generate('view', ['id' => $document['id']]); ?>" class="ri-eye-fill">View</a><br>
                                                <!-- Link to download the document -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>No content has been Submitted yet.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-5">
                <?php if (!empty($supervisor_notes)): ?>
                    <h5>supervisor notes</h5>

                    <ul>
                        <?php foreach ($supervisor_notes as $snote) : ?>

                            <li><?= $snote['note'] ?></li>
                        <?php endforeach; ?>

                    </ul>
                <?php endif; ?>
                <?php if (!empty($pnotes)): ?>
                    <h5>Your Notes</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-sm">
                            <tbody class="table-border-bottom-0">
                                <?php foreach ($pnotes as $pnote) : ?>
                                    <tr>
                                        <td><?= $pnote['note'] ?></td>
                                        <td>
                                            <form method="post" action="<?= $this->router->generate('mark_note') ?>">
                                                <button type="submit" name="note" value="<?= $pnote['note_id'] ?>" class="btn rounded-pill btn-outline-primary btn-sm waves-effect">Mark Done</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="javascript:void(0);" class="btn btn-warning mt-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddDocument">Add Document</a>
    </div>



</div>


<!-- Add Document Modal -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddDocument" aria-labelledby="offcanvasAddDocumentLabel">
    <div class="offcanvas-header border-bottom">
        <h5 id="offcanvasAddDocumentLabel" class="offcanvas-title">Upload Document</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 h-100">
        <form action="<?= $this->router->generate('upload_document'); ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="milestone_id" value="<?= $current_milestone['id']; ?>">
            <input type="hidden" name="project_id" value="<?= $_SESSION['user']['project_id']; ?>">

            <div class="mb-3">
                <label for="document" class="form-label">Select Document</label>
                <input type="file" class="form-control" id="document" name="document" required>
            </div>

            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalCenter">
                Upload
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>

            <!-- Modal -->
            <div class="modal fade" id="modalCenter" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modalCenterTitle">Confirm Upload</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to upload this document?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Yes, Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include '../app/Views/footer.php'; ?>