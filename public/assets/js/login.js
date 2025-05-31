jQuery(document).ready(function () {
    preventDevTools(false);
    preventMobileAccess();

    $("#login_form").submit(function () {
        const username = $("#login_username").val();
        const password = $("#login_password").val();
        const remember_me = $('#login_remember_me').is(':checked');

        if (username && password) {
            $("#login_submit").text("Please Wait..");
            $("#login_submit").attr("disabled", true);

            $("#login_message").addClass("d-none");
            $("#notification").addClass("d-none");

            var formData = new FormData();

            formData.append('username', username);
            formData.append('password', password);
            formData.append('remember_me', remember_me);

            formData.append('login', true);

            $.ajax({
                url: 'server',
                data: formData,
                type: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response) {
                        location.href = "main";
                    } else {
                        setTimeout(function () {
                            $("#login_message").removeClass("d-none");

                            $("#login_submit").text("Login");
                            $("#login_submit").removeAttr("disabled");
                        }, 1500);
                    }
                },
                error: function (_, _, error) {
                    console.error(error);
                }
            });
        }
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