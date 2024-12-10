@extends('master')

@section('content')
    <div class="message"></div>
    <div class="container">
        <div class="admin-content">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="d-inline">View Vehicle</h2>
                    <a href="{{ route('vehicle') }}" class="btn btn-success float-right m-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                        </svg>
                        Vehicle List
                    </a>
                    <a href="{{ route('pdf5', $vehicle->id) }}" class="btn btn-warning float-right m-2">Download PDF</a>
                </div>
                <div class="card-body position-relative">

                    <input type="hidden" id="vehicleId" value="{{ $vehicle->id }}">
                    <table class="table table-bordered" id="data">
                        <tr>
                            <th>Parking Number</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Vehicle Category</th>
                            <td>
                                <input type="hidden" id="charge" value="">
                                <input type="hidden" id="pcharge" value="">

                            </td>
                        </tr>
                        <tr>
                            <th>Vehicle Company Name</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Vehicle Registration Number</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Owner Name</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Owner Contact Number</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>In Time</th>
                            <td>
                                <input type="hidden" id="in_time" value="">


                            </td>
                        </tr>
                        <tr>
                            <th>Out Time</th>
                            <td>
                                <input type="hidden" id="out_time" value="">
                                <div id="clock" class="form-control out_time"></div>
                            </td>
                        </tr>
                        <tr>
                            <th>Parking Charges</th>
                            <td>
                                <input type="hidden" id="currency_format" value="">
                                <div id="parking_charge"></div>
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>



                            </td>
                        </tr>
                        <!-- <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                            <th>Remark</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                            <td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                <textarea class="form-control" name="" id="" cols="30" rows="5"></textarea>
                                                                                                                                                                                                                                                                                                                                                                                                                                            </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                        </tr> -->
                    </table>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">View Vehicle</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body position-relative">
                                    <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label><b>In Time :</b></label>
                                            <input type="hidden" name="vehicle_id" id="vehicle_id"
                                                value="{{ $vehicle->id }}">
                                            <input type="hidden" id="currency-format" value="">
                                            <input type="hidden" id="outtime" value="">
                                            <input type="text" id="in-time" readonly>

                                        </div>
                                        <div class="form-group">
                                            <label><b>Out Time :</b></label>
                                            <input type="text" readonly name="outtime" id="clock1">
                                        </div>
                                        <div class="form-group">
                                            <label><b>Parking Charge :</b></label>
                                            <input type="number" readonly name="charges" id="p-charge">
                                        </div>
                                        <div class="form-group">
                                            <label><b>Status :</b></label>
                                            <select class="form-control vehicle_status" name="vehicle_status"
                                                id="">
                                                <option value="1">Outgoing Vehicle</option>
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <input type="submit" id="updateVehicle" name="submit"
                                            class="btn btn-primary float-right" value="submit" required>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="loaddata" class="btn btn-dark float-right" data-toggle="modal"
                        data-target="#exampleModalCenter">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function displayclick() {
            var date = (new Date()).toISOString().split('T')[0];
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

            document.getElementById('clock').innerHTML = year + "-" + month + "-" + day + ' ' + hrs + ':' + min + ':' +
                sec + ' ' + en;
            // document.getElementById('clock').innerHTML = time;
        }
        setInterval(displayclick, 500);

        var parking_charges = document.getElementById('charge').value;
        var currency_format = document.getElementById('currency_format').value;
        var dateOne = document.getElementById('in_time').value;
        dateOne = dateOne.replace(/-/g, "/");
        const dateOneObj = new Date(dateOne);
        var dateTwoObj = new Date();
        var diff = (dateTwoObj - dateOneObj) / 1000;
        diff /= (60 * 60);
        var hours = Math.abs(Math.ceil(diff));
        console.log(diff);
        var charge = parseInt(hours) * parking_charges;
        document.getElementById('parking_charge').innerHTML = currency_format + charge;
    </script>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function formatDateTime(dateString) {
            const date = new Date(dateString);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0'); // 24-hour format
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');

            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }




        $(document).ready(function() {
            function loadData() {
                var id = $("#vehicleId").val();
                const api_token = localStorage.getItem('api_token');

                $.ajax({
                    url: `/api/vehicles/${id}`,
                    type: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + api_token
                    },
                    success: function(response) {
                        console.log(response);
                        $("#data").empty();
                        var status = response.vehicle.status == 0 ? "Vehicle In" : "Vehicle Out";

                        // Vehicle category price
                        var parkingCharges = parseInt(response.vehicle.category.parking_charge);
                        var inTime = new Date(response.vehicle.intime);
                        var currentTime = new Date();
                        var diffInHours = Math.ceil((currentTime - inTime) / 1000 / 60 / 60);
                        var charge = diffInHours * parkingCharges;

                        // Display data in the table
                        var output = `
                        <tr>
                            <th>Parking Number</th>
                            <td>${response.vehicle.parking_number}</td>
                        </tr>
                        <tr>
                            <th>Vehicle Category</th>
                            <td>${response.vehicle.category.category_name}</td>
                        </tr>
                        <tr>
                            <th>Vehicle Company Name</th>
                            <td>${response.vehicle.vehicle_company}</td>
                        </tr>
                        <tr>
                            <th>Vehicle Registration Number</th>
                            <td>${response.vehicle.registration_number}</td>
                        </tr>
                        <tr>
                            <th>Owner Name</th>
                            <td>${response.vehicle.owner_name}</td>
                        </tr>
                        <tr>
                            <th>Owner Contact Number</th>
                            <td>${response.vehicle.owner_contact}</td>
                        </tr>
                        <tr>
                            <th>In Time</th>
                            <td>${formatDateTime(response.vehicle.intime)}</td>
                        </tr>
                        <tr>
                            <th>Out Time</th>
                            <td>
                                <div id="clock" class="form-control out_time"></div>
                            </td>
                        </tr>
                        <tr>
                            <th>Parking Charges</th>
                            <td>
                                <div id="parking_charge">${charge}</div>
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>${status}</td>
                        </tr>
                    `;
                        $("#data").append(output);

                        // Set modal data with `in_time`, `out_time`, and calculated `charge`
                        $("#in-time").val(formatDateTime(response.vehicle.intime));
                        $("#clock1").val(formatDateTime(currentTime)); // For current time as out time
                        $("#p-charge").val(charge);
                    }
                });
            }

            loadData();

            // Handling the update button click in the modal

        });
    </script>
@endsection
