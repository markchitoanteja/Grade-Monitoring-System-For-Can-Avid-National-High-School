jQuery(document).ready(function () {
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
})