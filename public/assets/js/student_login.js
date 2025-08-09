jQuery(document).ready(function () {
    preventDevTools(true);
    preventMobileAccess(false);

    $("#student_login_form").submit(function () {
        const username = $("#student_login_username").val();
        const password = $("#student_login_password").val();
        const rememberMe = $("#student_login_remember_me").is(":checked");

        $("#notification").addClass("d-none").text("");

        $("#student_login_submit").prop("disabled", true);
        $("#student_login_submit").text("Please wait...");

        var formData = new FormData();

        formData.append('username', username);
        formData.append('password', password);
        formData.append('remember_me', rememberMe);

        formData.append('student_login', true);

        $.ajax({
            url: base_url + 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response) {
                    location.href = base_url + 'student/dashboard';
                } else {
                    $("#notification").removeClass("d-none").text("Invalid Username or Password");

                    $("#student_login_submit").removeAttr("disabled");
                    $("#student_login_submit").text("Login");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
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
})