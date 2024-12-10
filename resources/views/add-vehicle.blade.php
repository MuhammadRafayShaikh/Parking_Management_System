@extends('master')

@section('content')
    <div class="message"></div>
    <div class="container">
        <div class="admin-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="d-inline">Add Vehicle</h2>
                    <a href="vehicle.php" class="btn btn-success float-right">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                        </svg>
                        Vehicle List
                    </a>
                </div>
                <div class="card-body position-relative">

                    <div class="alert alert-danger">First Add Vehicle Category</div>
                    <div class="form-group">
                        <label>Vehicle Category</label>
                        <select class="form-control vehicle_cat" name="category_id" id="category_id">
                            <option value="">Select Vehicle Category</option>
                            @foreach ($category as $categories)
                                <option value="{{ $categories->id }}">{{ $categories->category_name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group">
                        <label>Vehicle Company</label>
                        <input type="text" class="form-control vehicle_company" name="vehicle_company"
                            placeholder="Vehicle Company" id="vehicle_company" required>
                    </div>
                    <div class="form-group">
                        <label>Registration Number</label>
                        <input type="text" class="form-control reg_no" name="registration_number"
                            placeholder="Registration Number" id="registration_number" required>
                    </div>
                    <div class="form-group">
                        <label>Owner Name</label>
                        <input type="text" class="form-control owner_name" id="owner_name" name="owner_name"
                            placeholder="Owner Name" required>
                    </div>
                    <div class="form-group">
                        <label>Owner Contact Number</label>
                        <input type="number" class="form-control owner_contact" id="owner_contact" name="owner_contact"
                            placeholder="Owner Contact Number" required>
                    </div>

                    <div class="form-group">
                        <label>Owner Email</label>
                        <input type="email" class="form-control owner_email" id="owner_email" name="owner_email"
                            placeholder="Owner Email" required>
                    </div>
                    <div class="form-group">
                        <label>Vehicle In Time</label>
                        <input type="hidden" class="in_time" id="intime" name="intime" value="">
                        <div id="clock1" class="form-control"></div>
                    </div>
                    <input type="submit" name="save" id="addVehicle" class="btn btn-dark float-right" value="Save"
                        required>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <script type="text/javascript">
        function displayclick() {
            var date = (new Date()).toISOString().split('T')[0];
            var time = new Date();
            var hrs = time.getHours();
            var min = time.getMinutes();
            var sec = time.getSeconds();
            var en = 'AM';

            if (hrs > 12) {
                en = 'PM';
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


            document.getElementById('intime').value = time;
            document.getElementById('clock1').innerHTML = date + ' ' + hrs + ':' + min + ':' + sec + ' ' + en;
        }
        setInterval(displayclick, 500);
    </script>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $("#addVehicle").on('click', function(e) {
                e.preventDefault();

                var category_id = $("#category_id").val();
                var vehicle_company = $("#vehicle_company").val();
                var registration_number = $("#registration_number").val();
                var owner_name = $("#owner_name").val();
                var owner_contact = $("#owner_contact").val();
                var owner_email = $("#owner_email").val();
                var intime = $("#intime").val();

                const api_token = localStorage.getItem('api_token');

                var formData = new FormData();

                formData.append('category_id', category_id);
                formData.append('vehicle_company', vehicle_company);
                formData.append('registration_number', registration_number);
                formData.append('owner_name', owner_name);
                formData.append('owner_contact', owner_contact);
                formData.append('owner_email', owner_email);
                formData.append('intime', intime);


                $.ajax({
                    url: 'api/vehicles',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'Authorization': 'Bearer ' + api_token
                    },
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        alert('Successfully Added Vehicle')
                        window.location.href = '/vehicle'
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", xhr.responseText);
                    }

                })
            })
        })
    </script>
@endsection
