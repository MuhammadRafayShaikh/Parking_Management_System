<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div id="admin-content" class="mt-5">
        <div class="message"></div>
        <div class="container">
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <div class="login-form">
                        <div class="card">
                            <div class="card-header p-2" style="background:#D85C27;">
                                <h2 class="text-center text-white m-2"></h2>
                            </div>
                            <div class="card-body login-form position-relative">
                                <!-- <div class="loader-container">
                  <div class="loader"></div>
                </div> -->
                                <form id="admin_Login" action="" method="POST" autocomplete="off">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" value="{{ old('email') }}"
                                            class="form-control username @error('email') is-invalid @enderror"
                                            name="username" id="username" placeholder="Username" required>
                                        <span class="text-danger">
                                            @error('email')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password"
                                            class="form-control password @error('password') is-invalid @enderror"
                                            name="password" id="password" value="{{ old('password') }}"
                                            placeholder="Password">
                                        <span class="text-danger">
                                            @error('password')
                                                {{ $message }}
                                            @enderror

                                        </span>
                                    </div>
                                    <input type="submit" class="btn text-white w-100" name="login" id="login"
                                        value="Login" style="background:#D85C27;">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.js" charset="utf-8"></script>
    <script src="assets/js/admin.js" charset="utf-8"></script>

    <script>
        $(document).ready(function() {
            $("#login").on('click', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var email = $("#username").val();
                var password = $("#password").val();

                $.ajax({
                    url: 'api/login', // Your API endpoint
                    type: 'POST',
                    data: JSON.stringify({
                        email: email,
                        password: password
                    }),
                    contentType: 'application/json',
                    success: function(response) {
                        // Handle successful login response
                        localStorage.setItem('api_token', response.token);
                        window.location.href = '/dashboard';
                    },
                    error: function(xhr) {
                        // Clear previous errors
                        $(".is-invalid").removeClass("is-invalid");
                        $(".text-danger").remove();

                        var errors = xhr.responseJSON.errors; // Get the validation errors

                        if (errors) {
                            // Display errors for 'email'
                            if (errors.email) {
                                $("#username").addClass("is-invalid");
                                $("#username").after('<span class="text-danger">' + errors
                                    .email[0] + '</span>');
                            }

                            // Display errors for 'password'
                            if (errors.password) {
                                $("#password").addClass("is-invalid");
                                $("#password").after('<span class="text-danger">' + errors
                                    .password[0] + '</span>');
                            }
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
