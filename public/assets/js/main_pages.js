jQuery(document).ready(function () {
    preventDevTools(false);
    preventMobileAccess(true);

    if (notification) {
        Swal.fire({
            title: notification.title,
            text: notification.text,
            icon: notification.icon
        });
    }

    $(".logout").click(function () {
        var formData = new FormData();

        formData.append('logout', true);

        $.ajax({
            url: base_url + 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response) {
                    location.href = base_url;
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

            formData.append('update_admin_account', true);

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

    $("#new_student_form").submit(function () {
        const lrn = $("#new_student_lrn").val();
        const strand_id = $("#new_student_strand_id").val();
        const grade_level = $("#new_student_grade_level").val();
        const section = $("#new_student_section").val();
        const first_name = $("#new_student_first_name").val();
        const middle_name = $("#new_student_middle_name").val();
        const last_name = $("#new_student_last_name").val();
        const birthday = $("#new_student_birthday").val();
        const sex = $("#new_student_sex").val();
        const email = $("#new_student_email").val();
        const address = $("#new_student_address").val();
        const image_file = $("#new_student_image")[0].files[0];

        $("#new_student_submit").text("Please Wait..");
        $("#new_student_submit").attr("disabled", true);

        is_form_loading("#new_student_modal", true);

        var formData = new FormData();

        formData.append('lrn', lrn);
        formData.append('strand_id', strand_id);
        formData.append('grade_level', grade_level);
        formData.append('section', section);
        formData.append('first_name', first_name);
        formData.append('middle_name', middle_name);
        formData.append('last_name', last_name);
        formData.append('birthday', birthday);
        formData.append('sex', sex);
        formData.append('email', email);
        formData.append('address', address);
        formData.append('image_file', image_file);

        formData.append('new_student', true);

        $.ajax({
            url: base_url + 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.lrn_ok && response.email_ok) {
                    location.reload();
                } else {
                    $("#new_student_submit").text("Submit");
                    $("#new_student_submit").removeAttr("disabled");

                    is_form_loading("#new_student_modal", false);

                    if (!response.lrn_ok) {
                        $("#new_student_lrn").addClass("is-invalid");
                        $("#error_new_student_lrn").removeClass("d-none");

                        $("#new_student_lrn").focus();
                    }

                    if (!response.email_ok) {
                        $("#new_student_email").addClass("is-invalid");
                        $("#error_new_student_email").removeClass("d-none");

                        $("#new_student_student_number").focus();
                    }
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#new_student_lrn").keydown(function () {
        $("#new_student_lrn").removeClass("is-invalid");
        $("#error_new_student_lrn").addClass("d-none");
    })

    $("#new_student_email").keydown(function () {
        $("#new_student_email").removeClass("is-invalid");
        $("#error_new_student_email").addClass("d-none");
    })

    $("#new_student_image").change(function (event) {
        var displayImage = $('#new_student_image_display');
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

    $(document).on("click", ".update_student_btn", function () {
        const account_id = $(this).data("account_id");

        $("#update_student_account_id").val(account_id);

        $("#update_student_submit").attr("disabled", true);
        $("#update_student_submit").text("Please Wait..");

        is_form_loading("#update_student_modal", true);

        $("#update_student_modal").modal("show");

        var formData = new FormData();

        formData.append('account_id', account_id);

        formData.append('get_student_data', true);

        $.ajax({
            url: base_url + 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                $("#update_student_image_display").attr("src", base_url + "public/assets/img/uploads/" + response.image);

                $("#update_student_old_image").val(response.image);
                $("#update_student_lrn").val(response.lrn);
                $("#update_student_strand_id").val(response.strand_id);
                $("#update_student_grade_level").val(response.grade_level);
                $("#update_student_section").val(response.section);
                $("#update_student_first_name").val(response.first_name);
                $("#update_student_middle_name").val(response.middle_name);
                $("#update_student_last_name").val(response.last_name);
                $("#update_student_birthday").val(response.birthday);
                $("#update_student_sex").val(response.sex);
                $("#update_student_email").val(response.email);
                $("#update_student_address").val(response.address);

                $("#update_student_submit").removeAttr("disabled");
                $("#update_student_submit").text("Save changes");

                is_form_loading("#update_student_modal", false);
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $(document).on("click", ".delete_student_btn", function () {
        const account_id = $(this).data("account_id");

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();

                formData.append('account_id', account_id);

                formData.append('delete_student', true);

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
                        }
                    },
                    error: function (_, _, error) {
                        console.error(error);
                    }
                });
            }
        });
    })

    $("#update_student_form").submit(function () {
        const account_id = $("#update_student_account_id").val();
        const old_image = $("#update_student_old_image").val();

        const lrn = $("#update_student_lrn").val();
        const strand_id = $("#update_student_strand_id").val();
        const grade_level = $("#update_student_grade_level").val();
        const section = $("#update_student_section").val();
        const first_name = $("#update_student_first_name").val();
        const middle_name = $("#update_student_middle_name").val();
        const last_name = $("#update_student_last_name").val();
        const birthday = $("#update_student_birthday").val();
        const sex = $("#update_student_sex").val();
        const email = $("#update_student_email").val();
        const address = $("#update_student_address").val();
        const image_file = $("#update_student_image")[0].files[0];

        $("#update_student_submit").text("Please Wait..");
        $("#update_student_submit").attr("disabled", true);

        is_form_loading("#update_student_modal", true);

        var formData = new FormData();

        formData.append('account_id', account_id);
        formData.append('old_image', old_image);
        formData.append('lrn', lrn);
        formData.append('strand_id', strand_id);
        formData.append('grade_level', grade_level);
        formData.append('section', section);
        formData.append('first_name', first_name);
        formData.append('middle_name', middle_name);
        formData.append('last_name', last_name);
        formData.append('birthday', birthday);
        formData.append('sex', sex);
        formData.append('email', email);
        formData.append('address', address);
        formData.append('image_file', image_file);

        formData.append('update_student', true);

        $.ajax({
            url: base_url + 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.lrn_ok && response.email_ok) {
                    location.reload();
                } else {
                    $("#update_student_submit").text("Submit");
                    $("#update_student_submit").removeAttr("disabled");

                    is_form_loading("#update_student_modal", false);

                    if (!response.lrn_ok) {
                        $("#update_student_lrn").addClass("is-invalid");
                        $("#error_update_student_lrn").removeClass("d-none");

                        $("#update_student_lrn").focus();
                    }

                    if (!response.email_ok) {
                        $("#update_student_email").addClass("is-invalid");
                        $("#error_update_student_email").removeClass("d-none");

                        $("#update_student_student_number").focus();
                    }
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#update_student_lrn").keydown(function () {
        $("#update_student_lrn").removeClass("is-invalid");
        $("#error_update_student_lrn").addClass("d-none");
    })

    $("#update_student_email").keydown(function () {
        $("#update_student_email").removeClass("is-invalid");
        $("#error_update_student_email").addClass("d-none");
    })

    $("#update_student_image").change(function (event) {
        var displayImage = $('#update_student_image_display');
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

    $("#new_backup").click(function () {
        Swal.fire({
            title: "Confirm Backup",
            text: "A backup of the current database will be created as an SQL file. Do you want to proceed?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, create backup"
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();

                formData.append('backup_database', true);

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
                        }
                    },
                    error: function (_, _, error) {
                        console.error(error);
                    }
                });
            }
        });
    })

    $(document).on("click", ".restore_backup", function () {
        var backup_file = $(this).data("filename");

        Swal.fire({
            title: "Confirm Restore",
            text: "You are about to restore the database to the selected point: " + backup_file + ". Do you want to proceed?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, restore",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();

                formData.append('backup_file', backup_file);

                formData.append('restore_database', true);

                $.ajax({
                    url: base_url + 'server',
                    data: formData,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        location.reload();
                    },
                    error: function (_, _, error) {
                        console.error("AJAX Error: ", error);
                    }
                });
            }
        });
    })

    $('.back-to-top').click(function (e) {
        e.preventDefault();

        $('html, body').animate({ scrollTop: 0 }, 500);
    })

    $("#new_strand_form").submit(function () {
        const code = $("#new_strand_code").val();
        const name = $("#new_strand_name").val();
        const description = $("#new_strand_description").val();

        $("#new_strand_submit").text("Please Wait..");
        $("#new_strand_submit").attr("disabled", true);

        is_form_loading("#new_strand_modal", true);

        var formData = new FormData();

        formData.append('code', code);
        formData.append('name', name);
        formData.append('description', description);

        formData.append('new_strand', true);

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
                    $("#new_strand_code").addClass("is-invalid");
                    $("#error_new_strand_code").removeClass("d-none");

                    $("#new_strand_submit").text("Submit");
                    $("#new_strand_submit").removeAttr("disabled");

                    is_form_loading("#new_strand_modal", false);
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#update_strand_form").submit(function () {
        const id = $("#update_strand_id").val();
        const code = $("#update_strand_code").val();
        const name = $("#update_strand_name").val();
        const description = $("#update_strand_description").val();

        $("#update_strand_submit").text("Please Wait..");
        $("#update_strand_submit").attr("disabled", true);

        is_form_loading("#update_strand_modal", true);

        var formData = new FormData();

        formData.append('id', id);
        formData.append('code', code);
        formData.append('name', name);
        formData.append('description', description);

        formData.append('update_strand', true);

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
                    $("#update_strand_code").addClass("is-invalid");
                    $("#error_update_strand_code").removeClass("d-none");

                    $("#update_strand_submit").text("Submit");
                    $("#update_strand_submit").removeAttr("disabled");

                    is_form_loading("#update_strand_modal", false);
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#new_strand_code").keydown(function () {
        $("#new_strand_code").removeClass("is-invalid");
        $("#error_new_strand_code").addClass("d-none");
    })

    $("#update_strand_code").keydown(function () {
        $("#update_strand_code").removeClass("is-invalid");
        $("#error_update_strand_code").addClass("d-none");
    })

    $(document).on("click", ".update_strand_btn", function () {
        const id = $(this).data("id");

        $("#update_strand_code").removeClass("is-invalid");
        $("#error_update_strand_code").addClass("d-none");

        $("#update_strand_submit").attr("disabled", true);
        $("#update_strand_submit").text("Please Wait..");

        is_form_loading("#update_strand_modal", true);

        $("#update_strand_id").val(id);

        $("#update_strand_modal").modal("show");

        var formData = new FormData();

        formData.append('id', id);

        formData.append('get_strand_data', true);

        $.ajax({
            url: base_url + 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                $("#update_strand_code").val(response.code);
                $("#update_strand_name").val(response.name);
                $("#update_strand_description").val(response.description);

                $("#update_strand_submit").removeAttr("disabled");
                $("#update_strand_submit").text("Save changes");

                is_form_loading("#update_strand_modal", false);
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $(document).on("click", ".delete_strand_btn", function () {
        const id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();

                formData.append('id', id);

                formData.append('delete_strand', true);

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
                        }
                    },
                    error: function (_, _, error) {
                        console.error(error);
                    }
                });
            }
        });
    })

    $("#new_subject_form").submit(function () {
        const name = $("#new_subject_name").val();
        const category = $("#new_subject_category").val();
        const grade_level = $("#new_subject_grade_level").val();
        const strand_id = $("#new_subject_strand_id").val();

        $("#new_subject_submit").text("Please Wait..");
        $("#new_subject_submit").attr("disabled", true);

        is_form_loading("#new_subject_modal", true);

        var formData = new FormData();

        formData.append('name', name);
        formData.append('category', category);
        formData.append('grade_level', grade_level);
        formData.append('strand_id', strand_id);

        formData.append('new_subject', true);

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
                    $("#new_subject_error_message").removeClass("d-none");

                    $("#new_subject_submit").text("Submit");
                    $("#new_subject_submit").removeAttr("disabled");

                    is_form_loading("#new_subject_modal", false);
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $(document).on("click", ".delete_subject_btn", function () {
        const id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();

                formData.append('id', id);

                formData.append('delete_subject', true);

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
                        }
                    },
                    error: function (_, _, error) {
                        console.error(error);
                    }
                });
            }
        });
    })

    $(document).on("click", ".update_subject_btn", function () {
        const id = $(this).data("id");

        $("#update_subject_submit").attr("disabled", true);
        $("#update_subject_submit").text("Please Wait..");

        is_form_loading("#update_subject_modal", true);

        $("#update_subject_id").val(id);

        $("#update_subject_modal").modal("show");

        var formData = new FormData();

        formData.append('id', id);

        formData.append('get_subject_data', true);

        $.ajax({
            url: base_url + 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                $("#update_subject_name").val(response.name);
                $("#update_subject_category").val(response.category);
                $("#update_subject_grade_level").val(response.grade_level);
                $("#update_subject_strand_id").val(response.strand_id);

                $("#update_subject_submit").removeAttr("disabled");
                $("#update_subject_submit").text("Save changes");

                is_form_loading("#update_subject_modal", false);
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#update_subject_form").submit(function () {
        const id = $("#update_subject_id").val();
        const name = $("#update_subject_name").val();
        const category = $("#update_subject_category").val();
        const grade_level = $("#update_subject_grade_level").val();
        const strand_id = $("#update_subject_strand_id").val();

        $("#update_subject_submit").text("Please Wait..");
        $("#update_subject_submit").attr("disabled", true);

        is_form_loading("#update_subject_modal", true);

        var formData = new FormData();

        formData.append('id', id);
        formData.append('name', name);
        formData.append('category', category);
        formData.append('grade_level', grade_level);
        formData.append('strand_id', strand_id);

        formData.append('update_subject', true);

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
                    $("#update_subject_error_message").removeClass("d-none");

                    $("#update_subject_submit").text("Save changes");
                    $("#update_subject_submit").removeAttr("disabled");

                    is_form_loading("#update_subject_modal", false);
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    function is_form_loading(modal_id, is_loading) {
        const $modal = $(modal_id);

        if (is_loading) {
            $(".actual-form").addClass("d-none");
            $(".loading").removeClass("d-none");

            $modal.on('keydown.bs.modal', function (e) {
                if (e.key === "Escape") {
                    e.stopImmediatePropagation();
                    e.preventDefault();
                }
            });

            $modal.on('click.dismiss.bs.modal', function (e) {
                e.stopImmediatePropagation();
                e.preventDefault();
            });

            $modal.find('[data-bs-dismiss="modal"]').attr('disabled', true);
            $modal.find('.btn-close').attr('disabled', true);

        } else {
            $(".actual-form").removeClass("d-none");
            $(".loading").addClass("d-none");

            $modal.off('keydown.bs.modal');
            $modal.off('click.dismiss.bs.modal');

            $modal.find('[data-bs-dismiss="modal"]').removeAttr('disabled');
            $modal.find('.btn-close').removeAttr('disabled');
        }
    }

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
})