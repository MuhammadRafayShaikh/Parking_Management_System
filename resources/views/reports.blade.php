@extends('master')

@section('content')
    <div class="message"></div>
    <div class="container">
        <div class="admin-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="d-inline">Reports</h2>
                </div>
                <div class="card-body position-relative">
                    <div id="table-data">
                        <form id="search-form" class="form-horizontal row" type="POST">
                            <div class="col-12 col-md-6 form-group">
                                <label for="">From Date</label>
                                <input type="datetime-local" name="from_date" id="from_date" class="form-control"
                                    value="<?php echo date('Y-m-d 00:00:00'); ?>">
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                <label for="">To Date</label>
                                <input type="datetime-local" name="to_date" id="to_date" class="form-control"
                                    value="<?php echo date('Y-m-d 23:59:59'); ?>">
                            </div>
                            <div class="col-12 col-md-4 form-group">
                                <label for="">Type</label>
                                <select name="search_type" id="search_type" class="form-control">
                                    <option value="0">All Records</option>
                                    <option value="1">Incoming Vehicle</option>
                                    <option value="2">Outgoing Vehicle</option>
                                    <option value="vehicle_number">Search Vehicle Number</option>
                                    <option value="user_name">Search User Name</option>
                                    <option value="phone_number">Search Phone Number</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4 form-group vehicle_number">
                                <label for="">Vehicle Number</label>
                                <input type="text" class="form-control" id="vehicle_number" name="vehicle_number"
                                    placeholder="Enter Vehicle Number">
                            </div>
                            <div class="col-12 col-md-4 form-group user_name">
                                <label for="">User Name</label>
                                <input type="text" class="form-control" id="user_name" name="user_name"
                                    placeholder="Enter User Name">
                            </div>
                            <div class="col-12 col-md-4 form-group phone_number">
                                <label for="">Phone Number</label>
                                <input type="number" class="form-control" id="phone_number" name="phone_number"
                                    placeholder="Enter Phone Number">
                            </div>
                            <div class="col-12 col-md-12 form-group">
                                <input type="submit" id="filterRecord" class="btn btn-dark btn-sm" name="submit"
                                    value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-header">
            <h2 class="d-inline">Reports</h2>
            <a href="#" id="download-pdf" class="btn btn-warning float-right">Download PDF</a>

        </div>

        <div class="card">
            <div class="card-body position-relative">
                <table class='table table-bordered w-100'>
                    <thead class="thead-dark">
                        <tr>
                            <th>Parking Number</th>
                            <th>Owner Name</th>
                            <th>Vehicle Reg Number</th>
                            <th>Vehicle DateTime</th>
                            <th>Status</th>
                            <th>Parking Charge</th>
                        </tr>
                    </thead>
                    <tbody id="data">

                    </tbody>
                    <tfoot id="totalSum">
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align:right">Total Sum:</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            function loadData() {
                var from_date = $("#from_date").val();
                var to_date = $("#to_date").val();
                var search_type = $("#search_type").val();
                var vehicle_number = $("#vehicle_number").val();
                var user_name = $("#user_name").val();
                var phone_number = $("#phone_number").val();

                const api_token = localStorage.getItem('api_token');

                $.ajax({
                    url: 'api/filter',
                    type: 'GET',
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                        search_type: search_type,
                        vehicle_number: vehicle_number,
                        user_name: user_name,
                        phone_number: phone_number
                    },
                    headers: {
                        'Authorization': 'Bearer ' + api_token,
                        'Content-Type': 'application/json'
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        $("#data").empty();
                        if (!response.message) {

                            $.each(response.vehicles, function(key, value) {
                                if (value.status == 1) {
                                    var status = "Vehicle Out"
                                } else {
                                    var status = "Vehicle In"
                                }

                                if (!value.outtime == null) {
                                    var outtime = value.outtime
                                } else {
                                    var outtime = 0
                                }

                                var output = `
                             <tr role="row" class="odd">
                            <td>
                                <span>${value.parking_number}</span>
                            </td>
                            <td>
                                <span>${value.owner_name}</span>
                            </td>
                            <td>
                                <span>${value.registration_number}</span>
                            </td>
                            <td>
                                <small>
                                    <b>Vehicle InTime:</b>
                                </small><br>
                                <small>${value.intime}</small>
                                <br>
                                <small>
                                    <b>Vehicle OutTime: </b>
                                </small>
                                <br>
                                <small>${outtime}</small>
                            </td>
                            <td>
                                <span class="badge badge-success">
                                    ${status}
                                </span>
                            </td>
                            <td>${value.charges}</td>
                        </tr>
                            `
                                $("#data").append(output)
                            })
                            $("#totalSum").empty()
                            var total = `
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align:right">Total Sum: </th>
                            <th>${response.charges}</th>
                        </tr>
                        `
                            $("#totalSum").append(total)

                        } else {
                            var output = `
                            <tr><td colspan="6" class="text-center">${response.message}</td></tr>
                            `
                            $("#data").append(output)
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: ", error);
                        console.log("Response Text: ", xhr
                            .responseText); // Log the full response
                    }
                });

            }
            loadData()

            $("#search-form").on('submit', function(event) {
                event.preventDefault();
                var from_date = $("#from_date").val();
                var to_date = $("#to_date").val();
                var search_type = $("#search_type").val();
                var vehicle_number = $("#vehicle_number").val();
                var user_name = $("#user_name").val();
                var phone_number = $("#phone_number").val();

                const api_token = localStorage.getItem('api_token');

                $.ajax({
                    url: 'api/filter',
                    type: 'GET',
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                        search_type: search_type,
                        vehicle_number: vehicle_number,
                        user_name: user_name,
                        phone_number: phone_number
                    },
                    headers: {
                        'Authorization': 'Bearer ' + api_token,
                        'Content-Type': 'application/json'
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        $("#data").empty();
                        if (!response.message) {

                            $.each(response.vehicles, function(key, value) {
                                if (value.status == 1) {
                                    var status = "Vehicle Out"
                                } else {
                                    var status = "Vehicle In"
                                }

                                if (!value.outtime == null) {
                                    var outtime = value.outtime
                                } else {
                                    var outtime = 0
                                }

                                var output = `
                             <tr role="row" class="odd">
                            <td>
                                <span>${value.parking_number}</span>
                            </td>
                            <td>
                                <span>${value.owner_name}</span>
                            </td>
                            <td>
                                <span>${value.registration_number}</span>
                            </td>
                            <td>
                                <small>
                                    <b>Vehicle InTime:</b>
                                </small><br>
                                <small>${value.intime}</small>
                                <br>
                                <small>
                                    <b>Vehicle OutTime: </b>
                                </small>
                                <br>
                                <small>${outtime}</small>
                            </td>
                            <td>
                                <span class="badge badge-success">
                                    ${status}
                                </span>
                            </td>
                            <td>${value.charges}</td>
                        </tr>
                            `
                                $("#data").append(output)
                            })
                            $("#totalSum").empty()
                            var total = `
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align:right">Total Sum: </th>
                            <th>${response.charges}</th>
                        </tr>
                        `
                            $("#totalSum").append(total)

                        } else {
                            var output = `
                            <tr><td colspan="6" class="text-center">${response.message}</td></tr>
                            `
                            $("#data").append(output)
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: ", error);
                        console.log("Response Text: ", xhr
                            .responseText); // Log the full response
                    }
                });
            });

            $(document).ready(function() {
                // PDF Download button event
                $("#download-pdf").on('click', function(event) {
                    event.preventDefault();

                    var from_date = $("#from_date").val();
                    var to_date = $("#to_date").val();
                    var search_type = $("#search_type").val();
                    var vehicle_number = $("#vehicle_number").val();
                    var user_name = $("#user_name").val();
                    var phone_number = $("#phone_number").val();

                    // Create URL with query parameters for filtered data
                    var downloadUrl =
                        `{{ route('reports.download') }}?from_date=${from_date}&to_date=${to_date}&search_type=${search_type}&vehicle_number=${vehicle_number}&user_name=${user_name}&phone_number=${phone_number}`;

                    // Open the URL to trigger the PDF download with the filtered data
                    window.location.href = downloadUrl;
                });
            });


        })
    </script>
@endsection
