<?php
if (!isset($_SESSION["student_user_id"])) {
    $_SESSION["notification"] = [
        "type" => "alert-danger bg-danger",
        "message" => "You must login first!",
    ];
    header("location: " . base_url("student/login"));
    exit();
}
?>

<?php include_once "views/student/templates/header.php"; ?>

<main id="main" class="main bg-light py-4">
    <div class="pagetitle">
        <h1 class="fs-4 mb-1">My Profile</h1>
        <nav>
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="<?= base_url('student/dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <form action="javascript:void(0)" id="update_profile_form">
            <div class="row g-4">

                <!-- Profile Summary -->
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 text-center">
                        <div class="card-body p-4">
                            <img src="<?= base_url('public/assets/img/uploads/' . $user_data['image']) ?>"
                                alt="Profile"
                                class="rounded-circle border mb-3"
                                style="width: 110px; height: 110px; object-fit: cover;">

                            <h5 class="fw-semibold mb-0">
                                <?= htmlspecialchars($user_data['first_name'] . ' ' . $user_data['last_name']) ?>
                            </h5>
                            <p class="text-muted small mb-2">
                                <?= htmlspecialchars($user_data['strand_code']) ?> - <?= htmlspecialchars($user_data['strand_name']) ?>
                            </p>

                            <div class="bg-light small p-2 rounded">
                                <?= htmlspecialchars($user_data['grade_level']) ?> - <?= htmlspecialchars($user_data['section']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Editable Details -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="bi bi-pencil-square me-1"></i> Personal Information
                            </h6>

                            <!-- Name -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label small" for="update_profile_first_name">First Name</label>
                                    <input type="text" class="form-control" id="update_profile_first_name" value="<?= htmlspecialchars($user_data['first_name']) ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small" for="update_profile_middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="update_profile_middle_name" value="<?= htmlspecialchars($user_data['middle_name']) ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small" for="update_profile_last_name">Last Name</label>
                                    <input type="text" class="form-control" id="update_profile_last_name" value="<?= htmlspecialchars($user_data['last_name']) ?>" required>
                                </div>
                            </div>

                            <!-- Birthday & Sex -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small" for="update_profile_birthday">Birthday</label>
                                    <input type="date" class="form-control" id="update_profile_birthday" name="birthday" value="<?= htmlspecialchars($user_data['birthday']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small" for="update_profile_sex">Sex</label>
                                    <select id="update_profile_sex" name="sex" class="form-select" required>
                                        <option value="Male" <?= $user_data['sex'] === 'Male' ? 'selected' : '' ?>>Male</option>
                                        <option value="Female" <?= $user_data['sex'] === 'Female' ? 'selected' : '' ?>>Female</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Contact -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small" for="update_profile_email">Email</label>
                                    <input type="email" class="form-control" id="update_profile_email" name="email" value="<?= htmlspecialchars($user_data['email']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small" for="update_profile_address">Address</label>
                                    <input type="text" class="form-control" id="update_profile_address" name="address" value="<?= htmlspecialchars($user_data['address']) ?>" required>
                                </div>
                            </div>

                            <!-- Read-only academic info -->
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label small">LRN</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($user_data['lrn']) ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Grade Level</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($user_data['grade_level']) ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Section</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($user_data['section']) ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary px-4" id="update_profile_btn">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>

<?php include_once "views/student/templates/footer.php"; ?>