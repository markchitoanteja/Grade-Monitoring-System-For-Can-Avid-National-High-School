        <?php include_once "../views/pages/components/account_settings.php" ?>
        <?php include_once "../views/pages/components/about_us.php" ?>

        <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>Students Grading System</span></strong>. All Rights Reserved.
            </div>
        </footer>

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <script>
            var user_id = "<?= $_SESSION["user_id"] ?>";
            var notification = <?= isset($_SESSION["notification"]) ? json_encode($_SESSION["notification"]) : json_encode(null) ?>;
            var current_page = "<?= $current_page ?>";
        </script>

        <script src="assets/vendor/chart.js/chart.umd.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
        <script src="assets/vendor/jquery/jquery.min.js"></script>
        <script src="assets/vendor/sweetalert2/js/sweetalert2.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/main_pages.js"></script>
    </body>

    </html>

    <?php unset($_SESSION["notification"]) ?>