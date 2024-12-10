<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title></title>

    <title></title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">

                <a href="{{ route('dashboard') }}" class="navbar-brand p-0 text-dark">Vehicle Parking</a>

                <h2><a href="dashboard.php" class="navbar-brand p-0 text-dark"></a></h2>

            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('vehicle-category') }}">Vehicle Category</a>
                </li>
                <li>
                    <a href="{{ route('vehicle') }}">Manage In Vehicle</a>
                </li>
                <li>
                    <a href="{{ route('outgoingvehicle') }}">Manage Out Vehicle</a>
                </li>
                <li>
                    <a href="{{ route('reports') }}">Reports</a>
                </li>
            </ul>
        </nav>
        <div class="container-fluid p-0">
            <div class="content">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-list" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                            </svg>
                            <!-- <span>Toggle Sidebar</span> -->
                        </button>
                        <!-- <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-align-justify"></i>
                        </button> -->
                        <div class="dropdown" style="padding:12px 0;">
                            <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Hi, Admin
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="profile.php">My Profile</a>

                                <button id="logoutbtn" class="dropdown-item" type="submit">Logout</button>

                            </div>
                        </div>
                    </div>
                </nav>


                @yield('content')


                <div class="copyright text-center mt-4">
                    <p>Copyright © .<a href="https://muhammadrafayshaikh.github.io/Monument" target="_blank">Admin</a>.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <input type="text" class="site-url" value="" hidden>
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.pdfmake.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/dataTables.vfs_fonts.min.js') }}"></script>
    <script src="{{ asset('assets/js/multi.min.js') }}"></script>
    <script src="{{ asset('assets/js/admin.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.table-data').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            });

            $('.select2').select2();

            // load image with jquery
            $('.image').change(function() {
                readURL(this);
            });

            // preview image before upload
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }

            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });

            $('#loaddata').on('click', function() {
                var time = new Date();
                var month = time.getUTCMonth() + 1; //months from 1-12
                var day = time.getUTCDate();
                var year = time.getUTCFullYear();
                var hrs = time.getHours();
                var min = time.getMinutes();
                var sec = time.getSeconds();
                var en = 'am';

                if (hrs > 12) {
                    en = 'pm';
                }

                if (hrs > 12) {
                    hrs = hrs - 12;
                }

                if (hrs == 0) {
                    hrs = 12;
                }

                if (hrs < 10) {
                    hrs = '0' + hrs;
                }

                if (min < 10) {
                    min = '0' + min;
                }

                if (sec < 10) {
                    sec = '0' + sec;
                }

                document.getElementById('clock1').innerHTML = year + "-" + month + "-" + day + ' ' + hrs +
                    ':' + min + ':' + sec + ' ' + en;
                var p_charges = document.getElementById('pcharge').value;
                var currency = document.getElementById('currency-format').value;
                var in_time = document.getElementById('in-time').value;
                in_time = in_time.replace(/-/g, "/");
                const in_timeObj = new Date(in_time);
                const out_timeObj = new Date();
                var difference = (out_timeObj - in_timeObj) / 1000;
                difference /= (60 * 60);
                var hour = Math.ceil(difference);
                var p_charge = parseInt(hour) * p_charges;
                document.getElementById('p-charge').innerHTML = currency + p_charge;
            });
            $('#logoutbtn').on('click', function() {
                const api_token = localStorage.getItem('api_token');
                $.ajax({
                    url: 'api/logout',
                    type: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + api_token
                    },
                    success: function(response) {
                        localStorage.removeItem('api_token');
                        window.location.href =
                            'http://localhost:8000/'; // Custom login route
                    },
                    error: function(xhr, status, error) {
                        console.log('Logout failed:', error);
                    }
                });
            });
        });
    </script>

</body>

</html>
