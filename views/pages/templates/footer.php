        <?php include_once "views/pages/components/account_settings.php" ?>
        <?php include_once "views/pages/components/about_us.php" ?>

        <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>Students Grading System</span></strong>. All Rights Reserved.
            </div>
        </footer>

        <a href="javascript:void(0)" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <script>
            const base_url = "<?= base_url() ?>";
            const user_id = "<?= $_SESSION["user_id"] ?>";
            const notification = <?= isset($_SESSION["notification"]) ? json_encode($_SESSION["notification"]) : json_encode(null) ?>;
            const current_page = "<?= $current_page ?>";
        </script>

        <script src="<?= base_url("public/assets/vendor/chart.js/chart.umd.js") ?>"></script>
        <script src="<?= base_url("public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
        <script src="<?= base_url("public/assets/vendor/simple-datatables/simple-datatables.js") ?>"></script>
        <script src="<?= base_url("public/assets/vendor/jquery/jquery.min.js") ?>"></script>
        <script src="<?= base_url("public/assets/vendor/sweetalert2/js/sweetalert2.min.js") ?>"></script>
        <script src="<?= base_url("public/assets/js/main.js") ?>"></script>
        <script src="<?= base_url("public/assets/js/main_pages.js?v=1.2.0") ?>"></script>
    </body>
</html>

<?php unset($_SESSION["notification"]) ?>