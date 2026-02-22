<?php include '../app/Views/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar for Notes -->
        <div class="col-md-3 p-3 border-end bg-light" style="height: 100vh; overflow-y: auto;">
            <h5 class="mb-3">Notes & To-Do</h5>

            <!-- Display Saved Notes -->
            <div class="mb-4 border border-primary rounded-3 p-3" style="border-width: 3px;">
                <h6 class="text-primary"><strong>From Supervisor:</strong></h6>
                <ol class="list-group list-group-numbered">
                    <?php foreach ($supervisor_notes as $note) : ?>
                        <li class="list-group-item"><?= htmlspecialchars($note['note']); ?></li>
                    <?php endforeach; ?>
                </ol>
            </div>
            <?php if ($_SESSION['user']['role'] == 'student') : ?>
                <hr>
                <div class="mb-4 border border-success rounded-3 p-3" style="border-width: 3px;">
                    <h6 class="text-success"><strong>Personal:</strong></h6>
                    <ol class="list-group list-group-numbered">
                        <?php foreach ($personal_notes as $note) : ?>
                            <li class="list-group-item"><?= htmlspecialchars($note['note']); ?></li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            <?php endif; ?>

            <hr>

            <!-- Add New Note -->
            <h5>Add New Note</h5>
            <form id="noteForm">
                <input type="hidden" name="document_id" value="<?= $document['id'] ?>">
                <input type="text" class="form-control mb-2" name="note" id="noteInput" placeholder="Write your note...">
                <button type="submit" class="btn btn-primary w-100">Save Note</button>
            </form>

            <!-- Grading Interface (for Supervisors Only) -->
            <?php if ($_SESSION['user']['role'] == 'supervisor') : ?>
                <hr>
                <h5>Grade Submission</h5>
                <form id="gradingForm">
                    <input type="hidden" name="document_id" value="<?= $document['id'] ?>">
                    <?php foreach ($submilestones as $submilestone) :
                        $gradeValue = isset($submilestone['grade']) && $submilestone['grade'] !== ''
                            ? $submilestone['grade']
                            : '';
                    ?>
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text">
                                <?= htmlspecialchars($submilestone['name']) . ' (' . $submilestone['max_marks'] . ')'; ?>
                            </span>
                            <input type="number"
                                step="0.1"
                                value="<?= $gradeValue ?>"
                                class="form-control <?= $gradeValue !== '' ? 'border-success' : '' ?>"
                                id="submilestone-<?= $submilestone['submilestone_id'] ?>"
                                name="grades[<?= $submilestone['submilestone_id'] ?>]"
                                min="0"
                                max="<?= $submilestone['max_marks']; ?>"
                                required>
                        </div>
                    <?php endforeach; ?>
                </form>

                <a href="<?php $this->router->generate('projects') ?>" class="btn btn-success w-100" disabled>Submit Grades</a>

            <?php endif; ?>
<?php if ($_SESSION['user']['role'] == 'admin') : ?>
            <div class="table-responsive p-2">
                <table class="table table-bordered table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Submilestone</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($submilestones as $submilestone) : ?>
                            <tr>
                                <td><?= htmlspecialchars($submilestone['name']); ?></td>
                                
                                <td><?= isset($submilestone['grade']) ? $submilestone['grade'] : 'N/A' ?>/<?=$submilestone['max_marks'];?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>








        </div>

        <!-- Main PDF Viewer -->
        <div class="col-md-9 p-2">
            <iframe src="pdf.php?file=<?= $document['path'] ?>" width="100%" height="100%" style="border: none;"></iframe>
        </div>
    </div>
</div>

<?php include '../app/Views/footer.php'; ?>

<script>
    $(document).ready(function() {
        // Function to check if all grade inputs have data
        function checkGradeFields() {
            let allFilled = true;
            $("input[name^='grades']").each(function() {
                if ($(this).val().trim() === "") {
                    allFilled = false;
                    return false; // break out of loop
                }
            });
            $("#submitGrades").prop("disabled", !allFilled);
        }

        // Initial check
        checkGradeFields();

        // Check when any grade input changes
        $("input[name^='grades']").on("input", function() {
            checkGradeFields();
        });

        // Save a Note
        $("#noteForm").submit(function(e) {
            e.preventDefault(); // Prevent page reload

            $.ajax({
                type: "POST",
                url: "<?= $this->router->generate('save_note') ?>",
                data: $(this).serialize(),
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success) {
                        let newNote = `<li class="list-group-item">${response.note.note}</li>`;
                        $(".border-primary .list-group").append(newNote); // Append directly
                        $("#noteInput").val(""); // Clear input field
                    } else {
                        alert("Failed to save note.");
                    }
                },
                error: function() {
                    alert("Error while saving note.");
                }
            });
        });

        // Auto-submit grade when supervisor updates an input field
        $("input[name^='grades']").on("change", function() {
            let inputField = $(this);
            let submilestoneId = inputField.attr("id").split("-")[1]; // Extract submilestone ID
            let grade = inputField.val().trim();
            let documentId = $("input[name='document_id']").val(); // Get document ID

            // Prevent empty submissions
            if (grade === "" || isNaN(grade)) {
                return;
            }

            inputField.prop("disabled", true); // Temporarily disable input during submission

            $.ajax({
                type: "POST",
                url: "<?= $this->router->generate('submit_grades') ?>",
                data: {
                    document_id: documentId,
                    submilestone_id: submilestoneId,
                    grade: grade
                },
                dataType: "json",
                cache: false,
                success: function(response) {
                    if (response.success) {
                        inputField.addClass("border-success"); // Green border on success
                        setTimeout(() => inputField.removeClass("border-success"), 2000); // Remove after 2 sec
                    } else {
                        alert("Failed to save grade: " + response.message);
                    }
                },
                error: function(xhr) {
                    console.error("AJAX Error:", xhr.responseText);
                    alert("Error while saving grade.");
                },
                complete: function() {
                    inputField.prop("disabled", false); // Re-enable input
                }
            });
        });
    });
</script>