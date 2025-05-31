jQuery(document).ready(function () {
    let grades = [];
    let chartInstance = null;

    preventDevTools(false);
    preventMobileAccess();

    if (notification) {
        Swal.fire({
            title: notification.title,
            text: notification.text,
            icon: notification.icon
        });
    }

    if (current_page == "student_grades") {
        $(".loading").removeClass("d-none");
        $(".canvas").addClass("d-none");

        setTimeout(function () {
            $(".loading").addClass("d-none");
            $(".canvas").removeClass("d-none");

            display_chart(['Component 1', 'Component 2', 'Component 3', 'Component 4'], "Sample Subject (Student Name)", [0, 0, 0, 0]);
        }, 250);
    }

    $(".logout").click(function () {
        var formData = new FormData();

        formData.append('logout', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response) {
                    location.href = "/";
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
            url: 'server',
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
                $("#account_settings_image_display").attr("src", "assets/img/uploads/" + response.image);
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
                url: 'server',
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

    $("#new_course_form").submit(function () {
        const code = $("#new_course_code").val();
        const description = $("#new_course_description").val();
        const years = $("#new_course_years").val();

        $("#new_course_submit").text("Please Wait..");
        $("#new_course_submit").attr("disabled", true);

        $(".actual-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        var formData = new FormData();

        formData.append('code', code);
        formData.append('description', description);
        formData.append('years', years);

        formData.append('new_course', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response) {
                    location.reload();
                } else {
                    $("#new_course_submit").text("Submit");
                    $("#new_course_submit").removeAttr("disabled");

                    $("#new_course_code").addClass("is-invalid");
                    $("#error_new_course_code").removeClass("d-none");

                    $(".loading").addClass("d-none");
                    $(".actual-form").removeClass("d-none");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#new_course_code").keydown(function () {
        $("#new_course_code").removeClass("is-invalid");
        $("#error_new_course_code").addClass("d-none");
    })

    $(document).on("click", ".delete_course", function () {
        const id = $(this).attr("course_id");

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

                formData.append('delete_course', true);

                $.ajax({
                    url: 'server',
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

    $(document).on("click", ".update_course", function () {
        const id = $(this).attr("course_id");

        $("#update_course_modal").modal("show");

        $(".loading").removeClass("d-none");
        $(".actual-form").addClass("d-none");

        var formData = new FormData();

        formData.append('id', id);

        formData.append('get_course_data', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response) {
                    $("#update_course_id").val(response.id);
                    $("#update_course_code").val(response.code);
                    $("#update_course_description").val(response.description);
                    $("#update_course_years").val(response.years);

                    $(".loading").addClass("d-none");
                    $(".actual-form").removeClass("d-none");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#update_course_form").submit(function () {
        const id = $("#update_course_id").val();
        const code = $("#update_course_code").val();
        const description = $("#update_course_description").val();
        const years = $("#update_course_years").val();

        $("#update_course_submit").text("Please Wait..");
        $("#update_course_submit").attr("disabled", true);

        $(".actual-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        var formData = new FormData();

        formData.append('id', id);
        formData.append('code', code);
        formData.append('description', description);
        formData.append('years', years);

        formData.append('update_course', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response) {
                    location.reload();
                } else {
                    $("#update_course_submit").text("Submit");
                    $("#update_course_submit").removeAttr("disabled");

                    $("#update_course_code").addClass("is-invalid");
                    $("#error_update_course_code").removeClass("d-none");

                    $(".loading").addClass("d-none");
                    $(".actual-form").removeClass("d-none");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#update_course_code").keydown(function () {
        $("#update_course_code").removeClass("is-invalid");
        $("#error_update_course_code").addClass("d-none");
    })

    $("#new_subject_course").change(function () {
        const code = $(this).val();

        var formData = new FormData();

        formData.append('code', code);

        formData.append('get_course_data_by_code', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                const years = parseInt(response.years);

                $("#new_subject_year").removeAttr("disabled");
                $("#new_subject_year").empty();

                for (let i = 1; i <= years; i++) {
                    const optionText = getOrdinalSuffix(i);

                    $("#new_subject_year").append(new Option(optionText + " Year", optionText));
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#new_subject_form").submit(function () {
        const code = $("#new_subject_code").val();
        const description = $("#new_subject_description").val();
        const lecture_units = $("#new_subject_lecture_units").val();
        const laboratory_units = $("#new_subject_laboratory_units").val();
        const hours_per_week = $("#new_subject_hours_per_week").val();
        const course = $("#new_subject_course").val();
        const year = $("#new_subject_year").val();
        const semester = $("#new_subject_semester").val();

        $("#new_subject_submit").text("Please Wait..");
        $("#new_subject_submit").attr("disabled", true);

        $(".actual-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        var formData = new FormData();

        formData.append('code', code);
        formData.append('description', description);
        formData.append('lecture_units', lecture_units);
        formData.append('laboratory_units', laboratory_units);
        formData.append('hours_per_week', hours_per_week);
        formData.append('course', course);
        formData.append('year', year);
        formData.append('semester', semester);

        formData.append('new_subject', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response) {
                    location.reload();
                } else {
                    $("#new_subject_code").addClass("is-invalid");
                    $("#error_new_subject_code").removeClass("d-none");

                    $("#new_subject_submit").text("Submit");
                    $("#new_subject_submit").removeAttr("disabled");

                    $(".actual-form").removeClass("d-none");
                    $(".loading").addClass("d-none");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#new_subject_code").keydown(function () {
        $("#new_subject_code").removeClass("is-invalid");
        $("#error_new_subject_code").addClass("d-none");
    })

    $(document).on("click", ".delete_subject", function () {
        const id = $(this).attr("subject_id");

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
                    url: 'server',
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

    $(document).on("click", ".update_subject", function () {
        const id = $(this).attr("subject_id");

        $("#update_subject_modal").modal("show");

        $(".loading").removeClass("d-none");
        $(".actual-form").addClass("d-none");

        var formData = new FormData();

        formData.append('id', id);

        formData.append('get_subject_data', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response) {
                    $("#update_subject_id").val(response.id);
                    $("#update_subject_code").val(response.code);
                    $("#update_subject_description").val(response.description);
                    $("#update_subject_lecture_units").val(response.lecture_units);
                    $("#update_subject_laboratory_units").val(response.laboratory_units);
                    $("#update_subject_hours_per_week").val(response.hours_per_week);
                    $("#update_subject_course").val(response.course);

                    var formData_2 = new FormData();

                    formData_2.append('code', response.course);

                    formData_2.append('get_course_data_by_code', true);

                    $.ajax({
                        url: 'server',
                        data: formData_2,
                        type: 'POST',
                        dataType: 'JSON',
                        processData: false,
                        contentType: false,
                        success: function (response_2) {
                            const years = parseInt(response_2.years);

                            $("#update_subject_year").removeAttr("disabled");
                            $("#update_subject_year").empty();

                            for (let i = 1; i <= years; i++) {
                                const optionText = getOrdinalSuffix(i);

                                $("#update_subject_year").append(new Option(optionText + " Year", optionText));
                            }

                            $("#update_subject_year").val(response.year);
                        },
                        error: function (_, _, error) {
                            console.error(error);
                        }
                    });
                    $("#update_subject_semester").val(response.semester);

                    $(".loading").addClass("d-none");
                    $(".actual-form").removeClass("d-none");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#update_subject_form").submit(function () {
        const id = $("#update_subject_id").val();
        const code = $("#update_subject_code").val();
        const description = $("#update_subject_description").val();
        const lecture_units = $("#update_subject_lecture_units").val();
        const laboratory_units = $("#update_subject_laboratory_units").val();
        const hours_per_week = $("#update_subject_hours_per_week").val();
        const course = $("#update_subject_course").val();
        const year = $("#update_subject_year").val();
        const semester = $("#update_subject_semester").val();

        $("#update_subject_submit").text("Please Wait..");
        $("#update_subject_submit").attr("disabled", true);

        $(".actual-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        var formData = new FormData();

        formData.append('id', id);
        formData.append('code', code);
        formData.append('description', description);
        formData.append('lecture_units', lecture_units);
        formData.append('laboratory_units', laboratory_units);
        formData.append('hours_per_week', hours_per_week);
        formData.append('course', course);
        formData.append('year', year);
        formData.append('semester', semester);

        formData.append('update_subject', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response) {
                    location.reload();
                } else {
                    $("#update_subject_code").addClass("is-invalid");
                    $("#error_update_subject_code").removeClass("d-none");

                    $("#update_subject_submit").text("Submit");
                    $("#update_subject_submit").removeAttr("disabled");

                    $(".actual-form").removeClass("d-none");
                    $(".loading").addClass("d-none");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#update_subject_course").change(function () {
        const code = $(this).val();

        var formData = new FormData();

        formData.append('code', code);

        formData.append('get_course_data_by_code', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                const years = parseInt(response.years);

                $("#update_subject_year").removeAttr("disabled");
                $("#update_subject_year").empty();

                for (let i = 1; i <= years; i++) {
                    const optionText = getOrdinalSuffix(i);

                    $("#update_subject_year").append(new Option(optionText + " Year", optionText));
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#update_subject_code").keydown(function () {
        $("#update_subject_code").removeClass("is-invalid");
        $("#error_update_subject_code").addClass("d-none");
    })

    $("#new_teacher_image").change(function (event) {
        var displayImage = $('#new_teacher_image_display');
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

    $("#new_teacher_form").submit(function () {
        const employee_number = $("#new_teacher_employee_number").val();
        const first_name = $("#new_teacher_first_name").val();
        const middle_name = $("#new_teacher_middle_name").val();
        const last_name = $("#new_teacher_last_name").val();
        const birthday = $("#new_teacher_birthday").val();
        const mobile_number = $("#new_teacher_mobile_number").val();
        const email = $("#new_teacher_email").val();
        const address = $("#new_teacher_address").val();
        const username = $("#new_teacher_username").val();
        const password = $("#new_teacher_password").val();
        const confirm_password = $("#new_teacher_confirm_password").val();
        const image_file = $("#new_teacher_image")[0].files[0];

        let is_error = false;

        if (password != confirm_password) {
            $("#new_teacher_password").addClass("is-invalid");
            $("#new_teacher_confirm_password").addClass("is-invalid");

            $("#error_new_teacher_password").removeClass("d-none");

            is_error = true;
        }

        if (!is_error) {
            $("#new_teacher_submit").text("Please Wait..");
            $("#new_teacher_submit").attr("disabled", true);

            $(".actual-form").addClass("d-none");
            $(".loading").removeClass("d-none");

            var formData = new FormData();

            formData.append('employee_number', employee_number);
            formData.append('first_name', first_name);
            formData.append('middle_name', middle_name);
            formData.append('last_name', last_name);
            formData.append('birthday', birthday);
            formData.append('mobile_number', mobile_number);
            formData.append('email', email);
            formData.append('address', address);
            formData.append('image_file', image_file);
            formData.append('username', username);
            formData.append('password', password);

            formData.append('new_teacher', true);

            $.ajax({
                url: 'server',
                data: formData,
                type: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.username_ok && response.employee_number_ok) {
                        location.reload();
                    } else {
                        $("#new_teacher_submit").text("Submit");
                        $("#new_teacher_submit").removeAttr("disabled");

                        $(".loading").addClass("d-none");
                        $(".actual-form").removeClass("d-none");

                        if (!response.username_ok) {
                            $("#new_teacher_username").addClass("is-invalid");
                            $("#error_new_teacher_username").removeClass("d-none");

                            $("#new_teacher_username").focus();
                        }

                        if (!response.employee_number_ok) {
                            $("#new_teacher_employee_number").addClass("is-invalid");
                            $("#error_new_teacher_employee_number").removeClass("d-none");

                            $("#new_teacher_employee_number").focus();
                        }
                    }
                },
                error: function (_, _, error) {
                    console.error(error);
                }
            });
        }
    })

    $("#new_teacher_employee_number").keydown(function () {
        $("#new_teacher_employee_number").removeClass("is-invalid");

        $("#error_new_teacher_employee_number").addClass("d-none");
    })

    $("#new_teacher_username").keydown(function () {
        $("#new_teacher_username").removeClass("is-invalid");

        $("#error_new_teacher_username").addClass("d-none");
    })

    $("#new_teacher_password").keydown(function () {
        $("#new_teacher_password").removeClass("is-invalid");
        $("#new_teacher_confirm_password").removeClass("is-invalid");

        $("#error_new_teacher_password").addClass("d-none");
    })

    $("#new_teacher_confirm_password").keydown(function () {
        $("#new_teacher_password").removeClass("is-invalid");
        $("#new_teacher_confirm_password").removeClass("is-invalid");

        $("#error_new_teacher_password").addClass("d-none");
    })

    $(document).on("click", ".update_teacher", function () {
        const id = $(this).attr("teacher_id");

        $("#update_teacher_modal").modal("show");

        $(".actual-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        var formData = new FormData();

        formData.append('id', id);

        formData.append('get_teacher_data', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                $("#update_teacher_account_id").val(response.account_id);
                $("#update_teacher_employee_number").val(response.employee_number);
                $("#update_teacher_first_name").val(response.first_name);
                $("#update_teacher_middle_name").val(response.middle_name);
                $("#update_teacher_last_name").val(response.last_name);
                $("#update_teacher_birthday").val(response.birthday);
                $("#update_teacher_mobile_number").val(response.mobile_number);
                $("#update_teacher_email").val(response.email);
                $("#update_teacher_address").val(response.address);
                $("#update_teacher_username").val(response.username);
                $("#update_teacher_image_display").attr("src", "assets/img/uploads/" + response.image);

                $("#update_teacher_old_image").val(response.image);
                $("#update_teacher_old_password").val(response.password);
                $("#update_teacher_old_username").val(response.username);
                $("#update_teacher_old_employee_number").val(response.employee_number);

                $(".actual-form").removeClass("d-none");
                $(".loading").addClass("d-none");
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $(document).on("click", ".delete_teacher", function () {
        const id = $(this).attr("teacher_id");

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

                formData.append('delete_teacher', true);

                $.ajax({
                    url: 'server',
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

    $("#update_teacher_form").submit(function () {
        const employee_number = $("#update_teacher_employee_number").val();
        const first_name = $("#update_teacher_first_name").val();
        const middle_name = $("#update_teacher_middle_name").val();
        const last_name = $("#update_teacher_last_name").val();
        const birthday = $("#update_teacher_birthday").val();
        const mobile_number = $("#update_teacher_mobile_number").val();
        const email = $("#update_teacher_email").val();
        const address = $("#update_teacher_address").val();
        const username = $("#update_teacher_username").val();
        const password = $("#update_teacher_password").val();
        const confirm_password = $("#update_teacher_confirm_password").val();
        const image_file = $("#update_teacher_image")[0].files[0];

        const account_id = $("#update_teacher_account_id").val();
        const old_image = $("#update_teacher_old_image").val();
        const old_password = $("#update_teacher_old_password").val();
        const old_employee_number = $("#update_teacher_old_employee_number").val();
        const old_username = $("#update_teacher_old_username").val();

        let is_error = false;
        let is_new_image = false;
        let is_new_password = false;

        if ((password || confirm_password) && (password != confirm_password)) {
            $("#update_teacher_password").addClass("is-invalid");
            $("#update_teacher_confirm_password").addClass("is-invalid");

            $("#error_update_teacher_password").removeClass("d-none");

            is_error = true;
        }

        if (!is_error) {
            if (image_file) {
                is_new_image = true;
            }

            if (password) {
                is_new_password = true;
            }

            $("#update_teacher_submit").text("Please Wait..");
            $("#update_teacher_submit").attr("disabled", true);

            $(".actual-form").addClass("d-none");
            $(".loading").removeClass("d-none");

            var formData = new FormData();

            formData.append('employee_number', employee_number);
            formData.append('first_name', first_name);
            formData.append('middle_name', middle_name);
            formData.append('last_name', last_name);
            formData.append('birthday', birthday);
            formData.append('mobile_number', mobile_number);
            formData.append('email', email);
            formData.append('address', address);
            formData.append('image_file', image_file);
            formData.append('username', username);
            formData.append('password', password);

            formData.append('account_id', account_id);
            formData.append('old_image', old_image);
            formData.append('old_password', old_password);
            formData.append('old_employee_number', old_employee_number);
            formData.append('old_username', old_username);

            formData.append('is_new_image', is_new_image);
            formData.append('is_new_password', is_new_password);

            formData.append('update_teacher', true);

            $.ajax({
                url: 'server',
                data: formData,
                type: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.username_ok && response.employee_number_ok) {
                        location.reload();
                    } else {
                        $("#update_teacher_submit").text("Submit");
                        $("#update_teacher_submit").removeAttr("disabled");

                        $(".loading").addClass("d-none");
                        $(".actual-form").removeClass("d-none");

                        if (!response.username_ok) {
                            $("#update_teacher_username").addClass("is-invalid");
                            $("#error_update_teacher_username").removeClass("d-none");

                            $("#update_teacher_username").focus();
                        }

                        if (!response.employee_number_ok) {
                            $("#update_teacher_employee_number").addClass("is-invalid");
                            $("#error_update_teacher_employee_number").removeClass("d-none");

                            $("#update_teacher_employee_number").focus();
                        }
                    }
                },
                error: function (_, _, error) {
                    console.error(error);
                }
            });
        }
    })

    $("#update_teacher_image").change(function (event) {
        var displayImage = $('#update_teacher_image_display');
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

    $("#update_teacher_employee_number").keydown(function () {
        $("#update_teacher_employee_number").removeClass("is-invalid");

        $("#error_update_teacher_employee_number").addClass("d-none");
    })

    $("#update_teacher_username").keydown(function () {
        $("#update_teacher_username").removeClass("is-invalid");

        $("#error_update_teacher_username").addClass("d-none");
    })

    $("#update_teacher_password").keydown(function () {
        $("#update_teacher_password").removeClass("is-invalid");
        $("#update_teacher_confirm_password").removeClass("is-invalid");

        $("#error_update_teacher_password").addClass("d-none");
    })

    $("#update_teacher_confirm_password").keydown(function () {
        $("#update_teacher_password").removeClass("is-invalid");
        $("#update_teacher_confirm_password").removeClass("is-invalid");

        $("#error_update_teacher_password").addClass("d-none");
    })

    $("#new_student_form").submit(function () {
        const student_number = $("#new_student_student_number").val();
        const course = $("#new_student_course").val();
        const year = $("#new_student_year").val();
        const section = $("#new_student_section").val();
        const first_name = $("#new_student_first_name").val();
        const middle_name = $("#new_student_middle_name").val();
        const last_name = $("#new_student_last_name").val();
        const birthday = $("#new_student_birthday").val();
        const mobile_number = $("#new_student_mobile_number").val();
        const email = $("#new_student_email").val();
        const address = $("#new_student_address").val();
        const username = $("#new_student_username").val();
        const password = $("#new_student_password").val();
        const confirm_password = $("#new_student_confirm_password").val();
        const image_file = $("#new_student_image")[0].files[0];

        let is_error = false;

        if (password != confirm_password) {
            $("#new_student_password").addClass("is-invalid");
            $("#new_student_confirm_password").addClass("is-invalid");

            $("#error_new_student_password").removeClass("d-none");

            is_error = true;
        }

        if (!is_error) {
            $("#new_student_submit").text("Please Wait..");
            $("#new_student_submit").attr("disabled", true);

            $(".actual-form").addClass("d-none");
            $(".loading").removeClass("d-none");

            var formData = new FormData();

            formData.append('student_number', student_number);
            formData.append('course', course);
            formData.append('year', year);
            formData.append('section', section);
            formData.append('first_name', first_name);
            formData.append('middle_name', middle_name);
            formData.append('last_name', last_name);
            formData.append('birthday', birthday);
            formData.append('mobile_number', mobile_number);
            formData.append('email', email);
            formData.append('address', address);
            formData.append('image_file', image_file);
            formData.append('username', username);
            formData.append('password', password);

            formData.append('new_student', true);

            $.ajax({
                url: 'server',
                data: formData,
                type: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.username_ok && response.student_number_ok) {
                        location.reload();
                    } else {
                        $("#new_student_submit").text("Submit");
                        $("#new_student_submit").removeAttr("disabled");

                        $(".loading").addClass("d-none");
                        $(".actual-form").removeClass("d-none");

                        if (!response.username_ok) {
                            $("#new_student_username").addClass("is-invalid");
                            $("#error_new_student_username").removeClass("d-none");

                            $("#new_student_username").focus();
                        }

                        if (!response.student_number_ok) {
                            $("#new_student_student_number").addClass("is-invalid");
                            $("#error_new_student_student_number").removeClass("d-none");

                            $("#new_student_student_number").focus();
                        }
                    }
                },
                error: function (_, _, error) {
                    console.error(error);
                }
            });
        }
    })

    $("#new_student_course").change(function () {
        const code = $(this).val();

        var formData = new FormData();

        formData.append('code', code);

        formData.append('get_course_data_by_code', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                const years = parseInt(response.years);

                $("#new_student_year").removeAttr("disabled");
                $("#new_student_year").empty();

                for (let i = 1; i <= years; i++) {
                    const optionText = getOrdinalSuffix(i);

                    $("#new_student_year").append(new Option(optionText + " Year", optionText));
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
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

    $("#new_student_student_number").keydown(function () {
        $("#new_student_student_number").removeClass("is-invalid");

        $("#error_new_student_student_number").addClass("d-none");
    })

    $("#new_student_username").keydown(function () {
        $("#new_student_username").removeClass("is-invalid");

        $("#error_new_student_username").addClass("d-none");
    })

    $("#new_student_password").keydown(function () {
        $("#new_student_password").removeClass("is-invalid");
        $("#new_student_confirm_password").removeClass("is-invalid");

        $("#error_new_student_password").addClass("d-none");
    })

    $("#new_student_confirm_password").keydown(function () {
        $("#new_student_password").removeClass("is-invalid");
        $("#new_student_confirm_password").removeClass("is-invalid");

        $("#error_new_student_password").addClass("d-none");
    })

    $(document).on("click", ".update_student", function () {
        const id = $(this).attr("student_id");

        $("#update_student_modal").modal("show");

        $(".actual-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        var formData = new FormData();

        formData.append('id', id);

        formData.append('get_student_data', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                $("#update_student_account_id").val(response.account_id);
                $("#update_student_student_number").val(response.student_number);
                $("#update_student_course").val(response.course);
                $("#update_student_section").val(response.section);
                $("#update_student_first_name").val(response.first_name);
                $("#update_student_middle_name").val(response.middle_name);
                $("#update_student_last_name").val(response.last_name);
                $("#update_student_birthday").val(response.birthday);
                $("#update_student_mobile_number").val(response.mobile_number);
                $("#update_student_email").val(response.email);
                $("#update_student_address").val(response.address);
                $("#update_student_username").val(response.username);
                $("#update_student_image_display").attr("src", "assets/img/uploads/" + response.image);

                $("#update_student_old_image").val(response.image);
                $("#update_student_old_password").val(response.password);
                $("#update_student_old_username").val(response.username);
                $("#update_student_old_student_number").val(response.student_number);

                const code = response.course;

                var formData_2 = new FormData();

                formData_2.append('code', code);

                formData_2.append('get_course_data_by_code', true);

                $.ajax({
                    url: 'server',
                    data: formData_2,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function (response_2) {
                        const years = parseInt(response_2.years);

                        $("#update_student_year").removeAttr("disabled");
                        $("#update_student_year").empty();

                        for (let i = 1; i <= years; i++) {
                            const optionText = getOrdinalSuffix(i);

                            $("#update_student_year").append(new Option(optionText + " Year", optionText));
                        }

                        $("#update_student_year").val(response.year);
                    },
                    error: function (_, _, error) {
                        console.error(error);
                    }
                });

                $(".actual-form").removeClass("d-none");
                $(".loading").addClass("d-none");
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $(document).on("click", ".delete_student", function () {
        const id = $(this).attr("student_id");

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

                formData.append('delete_student', true);

                $.ajax({
                    url: 'server',
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
        const student_number = $("#update_student_student_number").val();
        const course = $("#update_student_course").val();
        const year = $("#update_student_year").val();
        const section = $("#update_student_section").val();
        const first_name = $("#update_student_first_name").val();
        const middle_name = $("#update_student_middle_name").val();
        const last_name = $("#update_student_last_name").val();
        const birthday = $("#update_student_birthday").val();
        const mobile_number = $("#update_student_mobile_number").val();
        const email = $("#update_student_email").val();
        const address = $("#update_student_address").val();
        const username = $("#update_student_username").val();
        const password = $("#update_student_password").val();
        const confirm_password = $("#update_student_confirm_password").val();
        const image_file = $("#update_student_image")[0].files[0];

        const account_id = $("#update_student_account_id").val();
        const old_image = $("#update_student_old_image").val();
        const old_password = $("#update_student_old_password").val();
        const old_student_number = $("#update_student_old_student_number").val();
        const old_username = $("#update_student_old_username").val();

        let is_error = false;
        let is_new_image = false;
        let is_new_password = false;

        if ((password || confirm_password) && (password != confirm_password)) {
            $("#update_student_password").addClass("is-invalid");
            $("#update_student_confirm_password").addClass("is-invalid");

            $("#error_update_student_password").removeClass("d-none");

            is_error = true;
        }

        if (!is_error) {
            if (image_file) {
                is_new_image = true;
            }

            if (password) {
                is_new_password = true;
            }

            $("#update_student_submit").text("Please Wait..");
            $("#update_student_submit").attr("disabled", true);

            $(".actual-form").addClass("d-none");
            $(".loading").removeClass("d-none");

            var formData = new FormData();

            formData.append('student_number', student_number);
            formData.append('course', course);
            formData.append('year', year);
            formData.append('section', section);
            formData.append('first_name', first_name);
            formData.append('middle_name', middle_name);
            formData.append('last_name', last_name);
            formData.append('birthday', birthday);
            formData.append('mobile_number', mobile_number);
            formData.append('email', email);
            formData.append('address', address);
            formData.append('image_file', image_file);
            formData.append('username', username);
            formData.append('password', password);

            formData.append('account_id', account_id);
            formData.append('old_image', old_image);
            formData.append('old_password', old_password);
            formData.append('old_username', old_username);
            formData.append('old_student_number', old_student_number);

            formData.append('is_new_image', is_new_image);
            formData.append('is_new_password', is_new_password);

            formData.append('update_student', true);

            $.ajax({
                url: 'server',
                data: formData,
                type: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.username_ok && response.student_number_ok) {
                        location.reload();
                    } else {
                        $("#update_student_submit").text("Submit");
                        $("#update_student_submit").removeAttr("disabled");

                        $(".loading").addClass("d-none");
                        $(".actual-form").removeClass("d-none");

                        if (!response.username_ok) {
                            $("#update_student_username").addClass("is-invalid");
                            $("#error_update_student_username").removeClass("d-none");

                            $("#update_student_username").focus();
                        }

                        if (!response.student_number_ok) {
                            $("#update_student_student_number").addClass("is-invalid");
                            $("#error_update_student_student_number").removeClass("d-none");

                            $("#update_student_student_number").focus();
                        }
                    }
                },
                error: function (_, _, error) {
                    console.error(error);
                }
            });
        }
    })

    $("#update_student_course").change(function () {
        const code = $(this).val();

        var formData = new FormData();

        formData.append('code', code);

        formData.append('get_course_data_by_code', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                const years = parseInt(response.years);

                $("#update_student_year").removeAttr("disabled");
                $("#update_student_year").empty();

                for (let i = 1; i <= years; i++) {
                    const optionText = getOrdinalSuffix(i);

                    $("#update_student_year").append(new Option(optionText + " Year", optionText));
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
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

    $("#update_student_student_number").keydown(function () {
        $("#update_student_student_number").removeClass("is-invalid");

        $("#error_update_student_student_number").addClass("d-none");
    })

    $("#update_student_username").keydown(function () {
        $("#update_student_username").removeClass("is-invalid");

        $("#error_update_student_username").addClass("d-none");
    })

    $("#update_student_password").keydown(function () {
        $("#update_student_password").removeClass("is-invalid");
        $("#update_student_confirm_password").removeClass("is-invalid");

        $("#error_update_student_password").addClass("d-none");
    })

    $("#update_student_confirm_password").keydown(function () {
        $("#update_student_password").removeClass("is-invalid");
        $("#update_student_confirm_password").removeClass("is-invalid");

        $("#error_update_student_password").addClass("d-none");
    })

    $("#new_grade_component").click(function () {
        $("#new_grade_component_modal").modal("show");
    })

    $("#new_grade_component_form").submit(function () {
        const teacher_id = $("#new_grade_component_teacher_id").val();
        const subject_id = $("#new_grade_component_subject_id").val();
        const component = $("#new_grade_component_component").val();
        const weight = $("#new_grade_component_weight").val();

        $("#new_grade_component_submit").text("Please Wait..");
        $("#new_grade_component_submit").attr("disabled", true);

        $(".actual-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        var formData = new FormData();

        formData.append('subject_id', subject_id);
        formData.append('teacher_id', teacher_id);
        formData.append('component', component);
        formData.append('weight', weight);

        formData.append('new_grade_component', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.component_ok && response.weight_ok) {
                    location.reload();
                } else {
                    $("#new_grade_component_submit").text("Submit");
                    $("#new_grade_component_submit").removeAttr("disabled");

                    $(".loading").addClass("d-none");
                    $(".actual-form").removeClass("d-none");

                    if (!response.weight_ok) {
                        $("#new_grade_component_weight").addClass("is-invalid");
                        $("#error_new_grade_component_weight").removeClass("d-none");

                        $("#new_grade_component_weight").focus();
                    }

                    if (!response.component_ok) {
                        $("#new_grade_component_subject_id").addClass("is-invalid");
                        $("#error_new_grade_component_subject_id").removeClass("d-none");

                        $("#new_grade_component_component").addClass("is-invalid");
                        $("#error_new_grade_component_component").removeClass("d-none");

                        $("#new_grade_component_component").focus();
                    }
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#new_grade_component_subject_id").change(function () {
        $("#new_grade_component_subject_id").removeClass("is-invalid");
        $("#error_new_grade_component_subject_id").addClass("d-none");
        $("#new_grade_component_component").removeClass("is-invalid");
        $("#error_new_grade_component_component").addClass("d-none");
    })

    $("#new_grade_component_component").keydown(function () {
        $("#new_grade_component_subject_id").removeClass("is-invalid");
        $("#error_new_grade_component_subject_id").addClass("d-none");
        $("#new_grade_component_component").removeClass("is-invalid");
        $("#error_new_grade_component_component").addClass("d-none");
    })

    $("#new_grade_component_weight").keydown(function () {
        $("#new_grade_component_weight").removeClass("is-invalid");
        $("#error_new_grade_component_weight").addClass("d-none");
    })

    $(document).on("click", ".update_grade_component", function () {
        const id = $(this).attr("grade_component_id");

        $("#update_grade_component_modal").modal("show");

        $(".actual-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        var formData = new FormData();

        formData.append('id', id);

        formData.append('get_grade_component_data', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response) {
                    $("#update_grade_component_subject_id").val(response.subject_id);
                    $("#update_grade_component_component").val(response.component);
                    $("#update_grade_component_weight").val(response.weight);
                    $("#update_grade_component_old_weight").val(response.weight);
                    $("#update_grade_component_id").val(response.id);
                    $("#update_grade_component_teacher_id").val(response.teacher_id);

                    $(".actual-form").removeClass("d-none");
                    $(".loading").addClass("d-none");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $(document).on("click", ".delete_grade_component", function () {
        const id = $(this).attr("grade_component_id");

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

                formData.append('delete_grade_component', true);

                $.ajax({
                    url: 'server',
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

    $("#update_grade_component_form").submit(function () {
        const id = $("#update_grade_component_id").val();
        const subject_id = $("#update_grade_component_subject_id").val();
        const teacher_id = $("#update_grade_component_teacher_id").val();
        const component = $("#update_grade_component_component").val();
        const weight = $("#update_grade_component_weight").val();
        const old_weight = $("#update_grade_component_old_weight").val();

        $("#update_grade_component_submit").text("Please Wait..");
        $("#update_grade_component_submit").attr("disabled", true);

        $(".actual-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        var formData = new FormData();

        formData.append('id', id);
        formData.append('subject_id', subject_id);
        formData.append('teacher_id', teacher_id);
        formData.append('component', component);
        formData.append('weight', weight);
        formData.append('old_weight', old_weight);

        formData.append('update_grade_component', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.component_ok && response.weight_ok) {
                    location.reload();
                } else {
                    $("#update_grade_component_submit").text("Submit");
                    $("#update_grade_component_submit").removeAttr("disabled");

                    $(".loading").addClass("d-none");
                    $(".actual-form").removeClass("d-none");

                    if (!response.weight_ok) {
                        $("#update_grade_component_weight").addClass("is-invalid");
                        $("#error_update_grade_component_weight").removeClass("d-none");

                        $("#update_grade_component_weight").focus();
                    }

                    if (!response.component_ok) {
                        $("#update_grade_component_subject_id").addClass("is-invalid");
                        $("#error_update_grade_component_subject_id").removeClass("d-none");

                        $("#update_grade_component_component").addClass("is-invalid");
                        $("#error_update_grade_component_component").removeClass("d-none");

                        $("#update_grade_component_component").focus();
                    }
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#update_grade_component_subject_id").change(function () {
        $("#update_grade_component_subject_id").removeClass("is-invalid");
        $("#error_update_grade_component_subject_id").addClass("d-none");

        $("#update_grade_component_component").removeClass("is-invalid");
        $("#error_update_grade_component_component").addClass("d-none");
    })

    $("#update_grade_component_component").keydown(function () {
        $("#update_grade_component_subject_id").removeClass("is-invalid");
        $("#error_update_grade_component_subject_id").addClass("d-none");

        $("#update_grade_component_component").removeClass("is-invalid");
        $("#error_update_grade_component_component").addClass("d-none");
    })

    $("#update_grade_component_weight").keydown(function () {
        $("#update_grade_component_weight").removeClass("is-invalid");
        $("#error_update_grade_component_weight").addClass("d-none");
    })

    $("#new_student_grade_student_id").change(function () {
        const account_id = $(this).val();

        var formData = new FormData();

        formData.append('account_id', account_id);

        formData.append('get_student_data_by_account_id', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                const course = response.course;

                var formData_2 = new FormData();

                formData_2.append('code', course);

                formData_2.append('get_course_data_by_code', true);

                $.ajax({
                    url: 'server',
                    data: formData_2,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function (response_2) {
                        $("#new_student_grade_course").removeAttr("disabled");
                        $("#new_student_grade_course").empty();

                        $("#new_student_grade_course").append(
                            $('<option>', {
                                value: response_2.code,
                                text: response_2.description
                            })
                        );

                        const years = parseInt(response_2.years);

                        $("#new_student_grade_year").removeAttr("disabled");
                        $("#new_student_grade_year").empty();
                        $('#new_student_grade_year').append('<option value disabled selected></option>');

                        for (let i = 1; i <= years; i++) {
                            const optionText = getOrdinalSuffix(i);

                            $("#new_student_grade_year").append(new Option(optionText + " Year", optionText));
                        }

                        $("#new_student_grade_year").val(response.year);

                        const grade_course = $("#new_student_grade_course").val();
                        const grade_year = $("#new_student_grade_year").val();
                        const grade_semester = $("#new_student_grade_semester").val();

                        if (grade_course && grade_year && grade_semester) {
                            var formData_3 = new FormData();

                            formData_3.append('course', grade_course);
                            formData_3.append('year', grade_year);
                            formData_3.append('semester', grade_semester);

                            formData_3.append('get_subjects', true);

                            $.ajax({
                                url: 'server',
                                data: formData_3,
                                type: 'POST',
                                dataType: 'JSON',
                                processData: false,
                                contentType: false,
                                success: function (subjects) {
                                    if (subjects) {
                                        $('#new_student_grade_subject_id').removeAttr("disabled");
                                        $('#new_student_grade_subject_id').empty();
                                        $('#new_student_grade_subject_id').append('<option value disabled selected></option>');

                                        $.each(subjects, function (_, subject) {
                                            $('#new_student_grade_subject_id').append('<option value="' + subject.id + '">' + subject.description + '</option>');
                                        });
                                    }
                                },
                                error: function (_, _, error) {
                                    console.error(error);
                                }
                            });
                        }
                    },
                    error: function (_, _, error) {
                        console.error(error);
                    }
                });
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#new_student_grade_year").change(function () {
        const grade_course = $("#new_student_grade_course").val();
        const grade_year = $("#new_student_grade_year").val();
        const grade_semester = $("#new_student_grade_semester").val();

        if (grade_course && grade_year && grade_semester) {
            var formData = new FormData();

            formData.append('course', grade_course);
            formData.append('year', grade_year);
            formData.append('semester', grade_semester);

            formData.append('get_subjects', true);

            $.ajax({
                url: 'server',
                data: formData,
                type: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (subjects) {
                    if (subjects) {
                        $('#new_student_grade_subject_id').removeAttr("disabled");
                        $('#new_student_grade_subject_id').empty();
                        $('#new_student_grade_subject_id').append('<option value disabled selected></option>');

                        $.each(subjects, function (_, subject) {
                            $('#new_student_grade_subject_id').append('<option value="' + subject.id + '">' + subject.description + '</option>');
                        });
                    }
                },
                error: function (_, _, error) {
                    console.error(error);
                }
            });
        }
    })

    $("#new_student_grade_semester").change(function () {
        const grade_course = $("#new_student_grade_course").val();
        const grade_year = $("#new_student_grade_year").val();
        const grade_semester = $("#new_student_grade_semester").val();

        if (grade_course && grade_year && grade_semester) {
            var formData = new FormData();

            formData.append('course', grade_course);
            formData.append('year', grade_year);
            formData.append('semester', grade_semester);

            formData.append('get_subjects', true);

            $.ajax({
                url: 'server',
                data: formData,
                type: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (subjects) {
                    if (subjects) {
                        $('#new_student_grade_subject_id').removeAttr("disabled");
                        $('#new_student_grade_subject_id').empty();
                        $('#new_student_grade_subject_id').append('<option value disabled selected></option>');

                        $.each(subjects, function (_, subject) {
                            $('#new_student_grade_subject_id').append('<option value="' + subject.id + '">' + subject.description + '</option>');
                        });
                    }
                },
                error: function (_, _, error) {
                    console.error(error);
                }
            });
        }
    })

    $('#new_student_grade_grade_component_id').change(function () {
        $('#new_student_grade_grade').removeAttr("disabled");

        $('#grade_calculator').addClass('d-none');
    })

    $('#new_student_grade_subject_id').change(function () {
        const teacher_id = user_id;
        const subject_id = $(this).val();

        var formData = new FormData();

        formData.append('teacher_id', teacher_id);
        formData.append('subject_id', subject_id);

        formData.append('get_grade_component_data_by_teacher_id_and_subject_id', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (grade_components) {
                $('#new_student_grade_grade_component_id').removeAttr("disabled");
                $('#new_student_grade_grade_component_id').empty();
                $('#new_student_grade_grade_component_id').append("<option value selected disabled></option>");

                $('#grade_calculator').addClass('d-none');

                if (grade_components) {
                    $.each(grade_components, function (_, grade_component) {
                        $('#new_student_grade_grade_component_id').append('<option value="' + grade_component.id + '">' + grade_component.component + '</option>');
                    });
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $('#new_student_grade_grade').focus(function () {
        const component = $("#new_student_grade_grade_component_id option:selected").text();

        $('#grade_calculator').removeClass('d-none');

        $('#new_grade_input').focus();
        $('#grade_calculator_title').text("Calculate all grades of \"" + component + "\" here. (eg. 80%, 85%, etc.)")
    })

    $('#add_grade_button').click(function () {
        const component = $("#new_student_grade_grade_component_id option:selected").text();
        let grade = parseFloat($('#new_grade_input').val());

        if (!isNaN(grade)) {
            grades.push(grade);

            $('#new_grade_input').val('');

            let gradesList = '';

            $.each(grades, function (index, value) {
                gradesList += `<span class="badge bg-primary me-1">${component} #${index + 1}: ${value}</span>`;
            });

            $('#grades_list').html(gradesList);

            $("#error_new_grade_input").addClass("d-none");
            $("#new_grade_input").removeClass("is-invalid");
        }
    })

    $('#calculate_average_button').click(function () {
        if (grades.length > 0) {
            let total = grades.reduce(function (acc, grade) {
                return acc + grade;
            }, 0);

            let average = total / grades.length;

            $('#new_student_grade_grade').val(average.toFixed(2));

            $('#grade_calculator').addClass('d-none');

            $("#error_new_grade_input").addClass("d-none");
            $("#new_grade_input").removeClass("is-invalid");
        } else {
            $("#new_grade_input").addClass("is-invalid");
            $("#error_new_grade_input").removeClass("d-none");
        }
    })

    $('#clear_grades_button').click(function () {
        grades = [];

        $('#grades_list').html('');
        $('#new_grade_input').val('');

        $("#error_new_grade_input").addClass("d-none");
        $("#new_grade_input").removeClass("is-invalid");
    })

    $("#new_grade_input").keydown(function () {
        $("#error_new_grade_input").addClass("d-none");
        $("#new_grade_input").removeClass("is-invalid");
    })

    $("#new_student_grade_form").submit(function () {
        const teacher_id = $("#new_student_grade_teacher_id").val();
        const student_id = $("#new_student_grade_student_id").val();
        const subject_id = $("#new_student_grade_subject_id").val();
        const grade_component_id = $("#new_student_grade_grade_component_id").val();
        const course = $("#new_student_grade_course").val();
        const year = $("#new_student_grade_year").val();
        const semester = $("#new_student_grade_semester").val();
        const grade = $("#new_student_grade_grade").val();

        $("#new_student_grade_submit").text("Please Wait..");
        $("#new_student_grade_submit").attr("disabled", true);

        $(".actual-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        var formData = new FormData();

        formData.append('teacher_id', teacher_id);
        formData.append('student_id', student_id);
        formData.append('subject_id', subject_id);
        formData.append('grade_component_id', grade_component_id);
        formData.append('course', course);
        formData.append('year', year);
        formData.append('semester', semester);
        formData.append('grade', grade);

        formData.append('new_student_grade', true);

        $.ajax({
            url: 'server',
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
    })

    $(document).on("click", ".delete_student_grade", function () {
        const id = $(this).attr("student_grade_id");

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

                formData.append('delete_student_grade', true);

                $.ajax({
                    url: 'server',
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

    $(document).on("click", ".update_student_grade", function () {
        const id = $(this).attr("student_grade_id");

        $("#update_student_grade_modal").modal("show");

        $(".actual-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        var formData = new FormData();

        formData.append('id', id);

        formData.append('get_student_grade_data', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                $("#update_student_grade_student_id").val(response.student_id);

                const student_account_id = response.student_id;

                var formData_2 = new FormData();

                formData_2.append('account_id', student_account_id);

                formData_2.append('get_student_data_by_account_id', true);

                $.ajax({
                    url: 'server',
                    data: formData_2,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function (response_2) {
                        const course = response_2.course;

                        var formData_3 = new FormData();

                        formData_3.append('code', course);

                        formData_3.append('get_course_data_by_code', true);

                        $.ajax({
                            url: 'server',
                            data: formData_3,
                            type: 'POST',
                            dataType: 'JSON',
                            processData: false,
                            contentType: false,
                            success: function (response_3) {
                                $("#update_student_grade_course").removeAttr("disabled");
                                $("#update_student_grade_course").empty();

                                $("#update_student_grade_course").append(
                                    $('<option>', {
                                        value: response_3.code,
                                        text: response_3.description
                                    })
                                );

                                const years = parseInt(response_3.years);

                                $("#update_student_grade_year").removeAttr("disabled");
                                $("#update_student_grade_year").empty();

                                for (let i = 1; i <= years; i++) {
                                    const optionText = getOrdinalSuffix(i);

                                    $("#update_student_grade_year").append(new Option(optionText + " Year", optionText));
                                }

                                $("#update_student_grade_year").val(response.year);
                                $("#update_student_grade_semester").val(response.semester);

                                const grade_course = $("#update_student_grade_course").val();
                                const grade_year = $("#update_student_grade_year").val();
                                const grade_semester = $("#update_student_grade_semester").val();

                                if (grade_course && grade_year && grade_semester) {
                                    var formData_4 = new FormData();

                                    formData_4.append('course', grade_course);
                                    formData_4.append('year', grade_year);
                                    formData_4.append('semester', grade_semester);

                                    formData_4.append('get_subjects', true);

                                    $.ajax({
                                        url: 'server',
                                        data: formData_4,
                                        type: 'POST',
                                        dataType: 'JSON',
                                        processData: false,
                                        contentType: false,
                                        success: function (subjects) {
                                            if (subjects) {
                                                $('#update_student_grade_subject_id').removeAttr("disabled");
                                                $('#update_student_grade_subject_id').empty();

                                                $.each(subjects, function (_, subject) {
                                                    $('#update_student_grade_subject_id').append('<option value="' + subject.id + '">' + subject.description + '</option>');
                                                });

                                                $("#update_student_grade_subject_id").val(response.subject_id);

                                                const teacher_id = user_id;
                                                const subject_id = response.subject_id;

                                                var formData_5 = new FormData();

                                                formData_5.append('teacher_id', teacher_id);
                                                formData_5.append('subject_id', subject_id);

                                                formData_5.append('get_grade_component_data_by_teacher_id_and_subject_id', true);

                                                $.ajax({
                                                    url: 'server',
                                                    data: formData_5,
                                                    type: 'POST',
                                                    dataType: 'JSON',
                                                    processData: false,
                                                    contentType: false,
                                                    success: function (grade_components) {
                                                        $('#update_student_grade_grade_component_id').removeAttr("disabled");
                                                        $('#update_student_grade_grade_component_id').empty();

                                                        if (grade_components) {
                                                            $.each(grade_components, function (_, grade_component) {
                                                                $('#update_student_grade_grade_component_id').append('<option value="' + grade_component.id + '">' + grade_component.component + '</option>');
                                                            });
                                                        }

                                                        $("#update_student_grade_grade_component_id").val(response.grade_component_id);
                                                        $('#update_student_grade_grade').removeAttr("disabled");
                                                        $("#update_student_grade_grade").val(response.grade);

                                                        $("#update_student_grade_old_grade").val(response.grade);
                                                        $("#update_student_grade_old_grade_component_id").val(response.grade_component_id);
                                                        $("#update_student_grade_old_subject_id").val(response.subject_id);
                                                        $("#update_student_grade_id").val(response.id);

                                                        $('#update_grade_calculator').addClass('d-none');
                                                    },
                                                    error: function (_, _, error) {
                                                        console.error(error);
                                                    }
                                                });
                                            }
                                        },
                                        error: function (_, _, error) {
                                            console.error(error);
                                        }
                                    });
                                }
                            },
                            error: function (_, _, error) {
                                console.error(error);
                            }
                        });
                    },
                    error: function (_, _, error) {
                        console.error(error);
                    }
                });

                $(".actual-form").removeClass("d-none");
                $(".loading").addClass("d-none");
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#update_student_grade_student_id").change(function () {
        const account_id = $(this).val();

        var formData = new FormData();

        formData.append('account_id', account_id);

        formData.append('get_student_data_by_account_id', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                const course = response.course;

                var formData_2 = new FormData();

                formData_2.append('code', course);

                formData_2.append('get_course_data_by_code', true);

                $.ajax({
                    url: 'server',
                    data: formData_2,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function (response_2) {
                        $("#update_student_grade_course").removeAttr("disabled");
                        $("#update_student_grade_course").empty();

                        $("#update_student_grade_course").append(
                            $('<option>', {
                                value: response_2.code,
                                text: response_2.description
                            })
                        );

                        const years = parseInt(response_2.years);

                        $("#update_student_grade_year").removeAttr("disabled");
                        $("#update_student_grade_year").empty();
                        $('#update_student_grade_year').append('<option value disabled selected></option>');

                        for (let i = 1; i <= years; i++) {
                            const optionText = getOrdinalSuffix(i);

                            $("#update_student_grade_year").append(new Option(optionText + " Year", optionText));
                        }

                        $("#update_student_grade_year").val(response.year);

                        const grade_course = $("#update_student_grade_course").val();
                        const grade_year = $("#update_student_grade_year").val();
                        const grade_semester = $("#update_student_grade_semester").val();

                        if (grade_course && grade_year && grade_semester) {
                            var formData_3 = new FormData();

                            formData_3.append('course', grade_course);
                            formData_3.append('year', grade_year);
                            formData_3.append('semester', grade_semester);

                            formData_3.append('get_subjects', true);

                            $.ajax({
                                url: 'server',
                                data: formData_3,
                                type: 'POST',
                                dataType: 'JSON',
                                processData: false,
                                contentType: false,
                                success: function (subjects) {
                                    if (subjects) {
                                        $('#update_student_grade_subject_id').removeAttr("disabled");
                                        $('#update_student_grade_subject_id').empty();
                                        $('#update_student_grade_subject_id').append('<option value disabled selected></option>');

                                        $.each(subjects, function (_, subject) {
                                            $('#update_student_grade_subject_id').append('<option value="' + subject.id + '">' + subject.description + '</option>');
                                        });
                                    }
                                },
                                error: function (_, _, error) {
                                    console.error(error);
                                }
                            });
                        }
                    },
                    error: function (_, _, error) {
                        console.error(error);
                    }
                });
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#update_student_grade_year").change(function () {
        const grade_course = $("#update_student_grade_course").val();
        const grade_year = $("#update_student_grade_year").val();
        const grade_semester = $("#update_student_grade_semester").val();

        if (grade_course && grade_year && grade_semester) {
            var formData = new FormData();

            formData.append('course', grade_course);
            formData.append('year', grade_year);
            formData.append('semester', grade_semester);

            formData.append('get_subjects', true);

            $.ajax({
                url: 'server',
                data: formData,
                type: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (subjects) {
                    if (subjects) {
                        $('#update_student_grade_subject_id').removeAttr("disabled");
                        $('#update_student_grade_subject_id').empty();
                        $('#update_student_grade_subject_id').append('<option value disabled selected></option>');

                        $.each(subjects, function (_, subject) {
                            $('#update_student_grade_subject_id').append('<option value="' + subject.id + '">' + subject.description + '</option>');
                        });
                    }
                },
                error: function (_, _, error) {
                    console.error(error);
                }
            });
        }
    })

    $("#update_student_grade_semester").change(function () {
        const grade_course = $("#update_student_grade_course").val();
        const grade_year = $("#update_student_grade_year").val();
        const grade_semester = $("#update_student_grade_semester").val();

        if (grade_course && grade_year && grade_semester) {
            var formData = new FormData();

            formData.append('course', grade_course);
            formData.append('year', grade_year);
            formData.append('semester', grade_semester);

            formData.append('get_subjects', true);

            $.ajax({
                url: 'server',
                data: formData,
                type: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (subjects) {
                    if (subjects) {
                        $('#update_student_grade_subject_id').removeAttr("disabled");
                        $('#update_student_grade_subject_id').empty();
                        $('#update_student_grade_subject_id').append('<option value disabled selected></option>');

                        $.each(subjects, function (_, subject) {
                            $('#update_student_grade_subject_id').append('<option value="' + subject.id + '">' + subject.description + '</option>');
                        });
                    }
                },
                error: function (_, _, error) {
                    console.error(error);
                }
            });
        }
    })

    $('#update_student_grade_grade_component_id').change(function () {
        const old_grade = $('#update_student_grade_old_grade').val();
        const old_grade_component_id = $('#update_student_grade_old_grade_component_id').val();

        $('#update_student_grade_grade').removeAttr("disabled");

        if ($(this).val() == old_grade_component_id) {
            $('#update_student_grade_grade').val(old_grade);
        } else {
            $('#update_student_grade_grade').val("");
        }

        $('#update_grade_calculator').addClass('d-none');
    })

    $('#update_student_grade_subject_id').change(function () {
        const teacher_id = user_id;
        const subject_id = $(this).val();

        var formData = new FormData();

        formData.append('teacher_id', teacher_id);
        formData.append('subject_id', subject_id);

        formData.append('get_grade_component_data_by_teacher_id_and_subject_id', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (grade_components) {
                $('#update_student_grade_grade_component_id').removeAttr("disabled");
                $('#update_student_grade_grade_component_id').empty();
                $('#update_student_grade_grade_component_id').append("<option value selected disabled></option>");

                $('#grade_calculator').addClass('d-none');

                if (grade_components) {
                    $.each(grade_components, function (_, grade_component) {
                        $('#update_student_grade_grade_component_id').append('<option value="' + grade_component.id + '">' + grade_component.component + '</option>');
                    });
                }

                const old_subject_id = $("#update_student_grade_old_subject_id").val();
                const old_grade = $("#update_student_grade_old_grade").val();
                const old_grade_component_id = $("#update_student_grade_old_grade_component_id").val();

                if (subject_id == old_subject_id) {
                    $("#update_student_grade_grade_component_id").val(old_grade_component_id);
                    $("#update_student_grade_grade").val(old_grade);
                } else {
                    $("#update_student_grade_grade").val("");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $('#update_student_grade_grade').focus(function () {
        const component = $("#update_student_grade_grade_component_id option:selected").text();

        $('#update_grade_calculator').removeClass('d-none');

        $('#update_new_grade_input').focus();
        $('#update_grade_calculator_title').text("Calculate all grades of \"" + component + "\" here. (eg. 80%, 85%, etc.)")
    })

    $('#update_add_grade_button').click(function () {
        const component = $("#update_student_grade_grade_component_id option:selected").text();
        let grade = parseFloat($('#update_new_grade_input').val());

        if (!isNaN(grade)) {
            grades.push(grade);

            $('#update_new_grade_input').val('');

            let gradesList = '';

            $.each(grades, function (index, value) {
                gradesList += `<span class="badge bg-primary me-1">${component} #${index + 1}: ${value}</span>`;
            });

            $('#update_grades_list').html(gradesList);

            $("#update_error_new_grade_input").addClass("d-none");
            $("#update_new_grade_input").removeClass("is-invalid");
        }
    })

    $('#update_calculate_average_button').click(function () {
        if (grades.length > 0) {
            let total = grades.reduce(function (acc, grade) {
                return acc + grade;
            }, 0);

            let average = total / grades.length;

            $('#update_student_grade_grade').val(average.toFixed(2));

            $('#update_grade_calculator').addClass('d-none');

            $("#update_error_new_grade_input").addClass("d-none");
            $("#update_new_grade_input").removeClass("is-invalid");
        } else {
            $("#update_new_grade_input").addClass("is-invalid");
            $("#update_error_new_grade_input").removeClass("d-none");
        }
    })

    $('#update_clear_grades_button').click(function () {
        grades = [];

        $('#update_grades_list').html('');
        $('#update_new_grade_input').val('');

        $("#update_error_new_grade_input").addClass("d-none");
        $("#update_new_grade_input").removeClass("is-invalid");
    })

    $("#update_student_grade_form").submit(function () {
        const id = $("#update_student_grade_id").val();
        const teacher_id = $("#update_student_grade_teacher_id").val();
        const student_id = $("#update_student_grade_student_id").val();
        const subject_id = $("#update_student_grade_subject_id").val();
        const grade_component_id = $("#update_student_grade_grade_component_id").val();
        const course = $("#update_student_grade_course").val();
        const year = $("#update_student_grade_year").val();
        const semester = $("#update_student_grade_semester").val();
        const grade = $("#update_student_grade_grade").val();

        $("#update_student_grade_submit").text("Please Wait..");
        $("#update_student_grade_submit").attr("disabled", true);

        $(".actual-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        var formData = new FormData();

        formData.append('id', id);
        formData.append('teacher_id', teacher_id);
        formData.append('student_id', student_id);
        formData.append('subject_id', subject_id);
        formData.append('grade_component_id', grade_component_id);
        formData.append('course', course);
        formData.append('year', year);
        formData.append('semester', semester);
        formData.append('grade', grade);

        formData.append('update_student_grade', true);

        $.ajax({
            url: 'server',
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
    })

    $("#chart").submit(function () {
        const teacher_id = user_id;
        const student_id = $("#chart_student_id").val();
        const subject_id = $("#chart_subject_id").val();

        const student_name = $('#chart_student_id option:selected').text();
        const subject = $('#chart_subject_id option:selected').text();

        $(".loading").removeClass("d-none");
        $(".canvas").addClass("d-none");

        var formData = new FormData();

        formData.append('teacher_id', teacher_id);
        formData.append('student_id', student_id);
        formData.append('subject_id', subject_id);

        formData.append('get_grade_data', true);

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                $(".loading").addClass("d-none");
                $(".canvas").removeClass("d-none");

                const newLabels = response.components;
                const newDatasetLabel = student_name + " (" + subject + ")";
                const newDatasetData = response.grades;

                display_chart(newLabels, newDatasetLabel, newDatasetData);
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
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
                    url: 'server',
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
                    url: 'server',
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

    function display_chart(labels, dataset_label, dataset_data) {
        const ctx = $('#lineChart');

        if (chartInstance) {
            chartInstance.data.labels = labels;
            chartInstance.data.datasets[0].label = dataset_label;
            chartInstance.data.datasets[0].data = dataset_data;
            chartInstance.update();
        } else {
            chartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: dataset_label,
                        data: dataset_data,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }

    function getOrdinalSuffix(n) {
        const s = ["th", "st", "nd", "rd"], v = n % 100;

        return n + (s[(v - 20) % 10] || s[v] || s[0]);
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

    function preventMobileAccess() {
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