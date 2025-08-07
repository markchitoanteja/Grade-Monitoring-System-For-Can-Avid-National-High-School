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
}
?>

<?php include_once "views/pages/templates/header.php" ?>

<main id="main" class="main">
    <div class="pagetitle">
        <div class="row">
            <div class="col-6">
                <h1>Strands</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active">Strands</li>
                    </ol>
                </nav>
            </div>
            <div class="col-6">
                <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#new_strand_modal"><i class="bi bi-plus"></i> New Strand</button>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-journal-bookmark me-1"></i> All Strands</h5>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $strands = $db->select_all("strands", "id", "DESC") ?>
                                <?php if ($strands): ?>
                                    <?php foreach ($strands as $strand): ?>
                                        <tr>
                                            <td><?= $strand['code'] ?></td>
                                            <td title="<?= htmlspecialchars($strand['name']) ?>" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                <?= htmlspecialchars($strand['name']) ?>
                                            </td>
                                            <td title="<?= htmlspecialchars($strand['description']) ?>" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                <?= htmlspecialchars($strand['description']) ?>
                                            </td>
                                            
                                            <td class="text-center">
                                                <i class="bi bi-pencil-fill text-primary me-1 update_strand_btn" role="button" data-id="<?= $strand['id'] ?>"></i>
                                                <i class="bi bi-trash-fill text-danger delete_strand_btn" role="button" data-id="<?= $strand['id'] ?>"></i>
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

<?php include_once "views/pages/components/new_strand.php" ?>
<?php include_once "views/pages/components/update_strand.php" ?>

<?php include_once "views/pages/templates/footer.php" ?>