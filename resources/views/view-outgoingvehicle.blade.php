@extends('master')

@section('content')
    <div class="message"></div>
    <div class="container">
        <div class="admin-content">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="d-inline">View Outgoing Vehicle</h2>
                    <a href="{{ route('outgoingvehicle') }}" class="btn btn-success float-right m-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                        </svg>
                        Outgoing Vehicle List
                    </a>
                    <a href="{{ route('pdf4', $vehicle->id) }}" class="btn btn-warning float-right m-2">Download PDF</a>
                </div>
                <div class="card-body position-relative">
                    <input type="hidden" id="vehicle_id" value="{{ $vehicle->id }}">
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

                            </td>
                        </tr>
                        <tr>
                            <th>Out Time</th>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <th>Parking Charges</th>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>

                                Vehicle Out

                                Vehicle In

                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            function loadData() {
                var vehicle_id = $("#vehicle_id").val();
                const api_token = localStorage.getItem('api_token');

                $.ajax({
                    url: `/api/vehicles/${vehicle_id}`,
                    type: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + api_token
                    },
                    success: function(response) {
                        console.log(response);
                        $("#data").empty();

                        var output = `
                        <tr>
                            <th>Parking Number</th>
                            <td>${response.vehicle.parking_number}</td>
                        </tr>
                        <tr>
                            <th>Vehicle Category</th>
                            <td>
                                ${response.vehicle.category.category_name}
                                <input type="hidden" id="charge" value="">
                                <input type="hidden" id="pcharge" value="">
                            </td>
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
                            <td>
                                ${response.vehicle.intime}
                            </td>
                        </tr>
                        <tr>
                            <th>Out Time</th>
                            <td>
                                ${response.vehicle.outtime}
                            </td>
                        </tr>
                        <tr>
                            <th>Parking Charges</th>
                            <td>
                                ${response.vehicle.charges}
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>

                                Vehicle Out

                            </td>
                        </tr>
                        `
                        $("#data").append(output)
                    }
                })
            }

            loadData();
        })
    </script>
@endsection
