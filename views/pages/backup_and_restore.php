<?php
if (!isset($_SESSION["user_id"])) {
    $_SESSION["notification"] = [
        "type" => "alert-danger bg-danger",
        "message" => "You must login first!",
    ];

    header("location: " . base_url());

    exit();
} else {
    if ($_SESSION["user_type"] != "admin") {
        http_response_code(403);

        header("location: 403");

        exit();
    }

    $backup_dir = 'public/backup/';
    $files = array_diff(scandir($backup_dir), array('.', '..'));

    $files = array_filter($files, function ($file) use ($backup_dir) {
        return is_file($backup_dir . $file);
    });

    usort($files, function ($a, $b) use ($backup_dir) {
        return filemtime($backup_dir . $b) - filemtime($backup_dir . $a);
    });
}
?>

<?php include_once "views/pages/templates/header.php" ?>

<main id="main" class="main">
    <div class="pagetitle">
        <div class="row">
            <div class="col-6">
                <h1>Backup and Restore</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active">Backup and Restore</li>
                    </ol>
                </nav>
            </div>
            <div class="col-6">
                <button class="btn btn-primary float-end" id="new_backup"><i class="bi bi-download"></i> Create New Backup</button>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-journal-bookmark me-1"></i> All Backups</h5>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>File Name</th>
                                    <th>Size</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($files): ?>
                                    <?php foreach ($files as $file): ?>
                                        <?php
                                        $file_path = $backup_dir . $file;
                                        ?>
                                        <tr>
                                            <td><?= (new DateTime('@' . filemtime($file_path)))->format('F j, Y h:i A') ?></td>
                                            <td><?= $file ?></td>
                                            <td><?= round(filesize($file_path) / 1024, 2) ?> KB</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success restore_backup" data-filename="<?= $file ?>">
                                                    <i class="bi bi-arrow-counterclockwise"></i> Restore
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once "views/pages/templates/footer.php" ?>