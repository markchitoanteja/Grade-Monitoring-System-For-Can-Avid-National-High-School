$(document).ready(function () {
    preventDevTools(true);
    preventMobileAccess(false);

    if (notification) {
        Swal.fire({
            title: notification.title,
            text: notification.text,
            icon: notification.icon
        });
    }

    $(".logout").click(function () {
        var formData = new FormData();

        formData.append('student_logout', true);

        $.ajax({
            url: base_url + 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response) {
                    location.href = base_url + 'student/login';
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#account_settings").click(function () {
        $("#account_settings_modal").modal("show");

        $(".actual-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        var formData = new FormData();

        formData.append('user_id', user_id);

        formData.append('get_admin_data', true);

        $.ajax({
            url: base_url + 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                $(".loading").addClass("d-none");
                $(".actual-form").removeClass("d-none");

                $("#account_settings_name").val(response.name);
                $("#account_settings_username").val(response.username);
                $("#account_settings_image_display").attr("src", base_url + "public/assets/img/uploads/" + response.image);
                $("#account_settings_id").val(response.id);
                $("#account_settings_old_password").val(response.password);
                $("#account_settings_old_image").val(response.image);
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#acccount_settings_form").submit(function () {
        const name = $("#account_settings_name").val();
        const username = $("#account_settings_username").val();
        const password = $("#account_settings_password").val();
        const confirm_password = $("#account_settings_confirm_password").val();
        const image_input = $("#account_settings_image")[0];

        const id = $("#account_settings_id").val();
        const old_password = $("#account_settings_old_password").val();
        const old_image = $("#account_settings_old_image").val();

        let is_new_password = false;
        let is_new_image = false;

        let is_error = false;

        if (password) {
            if (password != confirm_password) {
                $("#account_settings_password").addClass("is-invalid");
                $("#account_settings_confirm_password").addClass("is-invalid");

                $("#error_account_settings_password").removeClass("d-none");

                is_error = true;
            } else {
                is_new_password = true;
            }
        }

        if (!is_error) {
            if (image_input.files.length > 0) {
                var image_file = image_input.files[0];

                is_new_image = true;
            }

            $("#account_settings_submit").text("Please Wait..");
            $("#account_settings_submit").attr("disabled", true);

            var formData = new FormData();

            formData.append('name', name);
            formData.append('username', username);
            formData.append('password', password);
            formData.append('image_file', image_file);
            formData.append('id', id);
            formData.append('old_password', old_password);
            formData.append('old_image', old_image);
            formData.append('is_new_password', is_new_password);
            formData.append('is_new_image', is_new_image);

            formData.append('update_student_account', true);

            $.ajax({
                url: base_url + 'server',
                data: formData,
                type: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response) {
                        location.reload();
                    } else {
                        $("#account_settings_username").addClass("is-invalid");
                        $("#error_account_settings_username").removeClass("d-none");

                        $("#account_settings_submit").text("Save changes");
                        $("#account_settings_submit").removeAttr("disabled");
                    }
                },
                error: function (_, _, error) {
                    console.error(error);
                }
            });
        }
    })

    $("#account_settings_username").keydown(function () {
        $("#account_settings_username").removeClass("is-invalid");
        $("#error_account_settings_username").addClass("d-none");
    })

    $("#account_settings_password").keydown(function () {
        $("#account_settings_password").removeClass("is-invalid");
        $("#account_settings_confirm_password").removeClass("is-invalid");

        $("#error_account_settings_password").addClass("d-none");
    })

    $("#account_settings_confirm_password").keydown(function () {
        $("#account_settings_password").removeClass("is-invalid");
        $("#account_settings_confirm_password").removeClass("is-invalid");

        $("#error_account_settings_password").addClass("d-none");
    })

    $("#account_settings_image").change(function (event) {
        var displayImage = $('#account_settings_image_display');
        var file = event.target.files[0];

        if (file) {
            var imageURL = URL.createObjectURL(file);

            displayImage.attr('src', imageURL);

            displayImage.on('load', function () {
                URL.revokeObjectURL(imageURL);
            });
        } else {
            displayImage.attr('src', "assets/img/uploads/default-user-image.png");
        }
    })

    $("#update_profile_form").submit(function () {
        const first_name = $("#update_profile_first_name").val();
        const middle_name = $("#update_profile_middle_name").val();
        const last_name = $("#update_profile_last_name").val();
        const birthday = $("#update_profile_birthday").val();
        const sex = $("#update_profile_sex").val();
        const email = $("#update_profile_email").val();
        const address = $("#update_profile_address").val();

        $("#update_profile_btn").text("Please Wait..");
        $("#update_profile_btn").attr("disabled", true);

        var formData = new FormData();

        formData.append('first_name', first_name);
        formData.append('middle_name', middle_name);
        formData.append('last_name', last_name);
        formData.append('birthday', birthday);
        formData.append('sex', sex);
        formData.append('email', email);
        formData.append('address', address);

        formData.append('update_student_profile', true);

        $.ajax({
            url: base_url + 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response) {
                    location.reload();
                } else {
                    // Reset button state
                    $("#update_profile_btn").text("Save changes");
                    $("#update_profile_btn").removeAttr("disabled");

                    // Email error UI
                    $("#update_profile_email").addClass("is-invalid");
                    if (!$("#update_profile_email").next(".invalid-feedback").length) {
                        $("#update_profile_email").after('<div class="invalid-feedback">Email already exists</div>');
                    }
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#update_profile_email").keydown(function () {
        $("#update_profile_email").removeClass("is-invalid");
        $("#update_profile_email").next(".invalid-feedback").remove();
    })

    function preventDevTools(enable) {
        if (!enable) return;

        document.addEventListener('contextmenu', (e) => {
            e.preventDefault();
        });

        document.addEventListener('keydown', (e) => {
            const key = e.key.toLowerCase();

            if (
                (e.ctrlKey && e.shiftKey && (key === 'i' || key === 'j')) ||
                (e.ctrlKey && (key === 'u' || key === 's' || key === 'p')) ||
                key === 'f12'
            ) {
                e.preventDefault();
            }
        });
    }

    function preventMobileAccess(enable) {
        if (!enable) return;

        if (/Mobi|Android|iPhone|iPad|iPod/i.test(navigator.userAgent)) {
            document.body.innerHTML = `
            <div style="display: flex; height: 100vh; align-items: center; justify-content: center; background-color: #f8d7da; color: #721c24; text-align: center; padding: 20px; font-family: Arial, sans-serif;">
                <div>
                    <h1 style="font-size: 3rem;">Access Denied</h1>
                    <p style="font-size: 1.5rem;">This page is not accessible on mobile devices.</p>
                </div>
            </div>`;
        }
    }
});