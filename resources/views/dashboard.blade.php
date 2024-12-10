@extends('master')

@section('content')
    <div class="admin-content">
        <div class="container">
            <div id="admin-dashboard">
                <div>
                </div>
                <div class="row">
                    <div class="col-md-3">

                        <div class="card young-passion-gradient">
                            <div class="card-body text-center">
                                <span class="icon"><i class="fas fa-taxi"></i></span>
                                <p class="card-text mb-3" id="todayincoming"></p>
                                <h5 class="card-title text-white mb-0">Today Incoming Vehicle Entries</h5>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">

                        <div class="card young-passion-gradient">
                            <div class="card-body text-center">
                                <span class="icon"><i class="fas fa-taxi"></i></span>
                                <p class="card-text mb-3" id="todayoutgoing"></p>
                                <h5 class="card-title text-white mb-0">Today Outgoing Vehicle Entries</h5>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">

                        <div class="card purple-gradient">
                            <div class="card-body text-center">
                                <span class="icon"><i class="fas fa-file"></i></span>
                                <p class="card-text mb-3" id="categories"></p>
                                <h5 class="card-title text-white mb-0">Vehicle Category</h5>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">

                        <div class="card peach-gradient">
                            <div class="card-body text-center">
                                <span class="icon"><i class="fas fa-taxi"></i></span>
                                <p class="card-text mb-3" id="incoming"></p>
                                <h5 class="card-title text-white mb-0">Total Incoming Vehicle</h5>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-header">
                            <h2>Latest Incoming Vehicle</h2>
                        </div>
                        <div class="card-body table-responsive">

                            <table class="table table-bordered">
                                <thead>
                                    <th>S.No</th>
                                    <th>Parking Number</th>
                                    <th>Owner Name</th>
                                    <th>Vehicle Reg Number</th>
                                    <th>Vehicle InTime</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="data">

                                    {{-- <tr class='tr-shadow'>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <br>
                                            <small></small>
                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                            <ul class="action-list">
                                                <li><a href="view-vehicle.php" class="btn btn-primary btn-sm"><img
                                                            src="images/eye.png" alt=""></a></li>
                                            </ul>
                                        </td>
                                    </tr> --}}

                                    <tr>
                                        <td colspan="6" align="center">Please Wait...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {

            function loadData() {
                const api_token = localStorage.getItem('api_token');

                $.ajax({
                    url: '/api/dashboardData',
                    type: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + api_token
                    },
                    beforeSend: function() {
                        $("#data").html(`<tr>
                                        <td colspan="6" align="center">Please Wait...</td>
                                    </tr>`);
                    },
                    success: function(response) {
                        console.log(response);
                        $("#data").empty();
                        $("#todayincoming").html(response.todayincoming)
                        $("#todayoutgoing").html(response.todayoutgoing)
                        $("#categories").html(response.category)
                        $("#incoming").html(response.incoming)
                        if (response.vehicles) {
                            $.each(response.vehicles, function(key, value) {
                                // console.log(value);
                                const url = `view-vehicle/${value.id}`
                                var output = `
                            <tr class='tr-shadow'>
                                        <td>${value.id}</td>
                                        <td>${value.parking_number}</td>
                                        <td>${value.owner_name}</td>
                                        <td>${value.registration_number}</td>
                                        <td>
                                            ${value.intime}
                                            <br>
                                            <small></small>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">Vehicle In</span>
                                        </td>
                                        <td>
                                            <ul class="action-list">
                                                <li><a href="${url}" class="btn btn-primary btn-sm"><img
                                                            src="images/eye.png" alt=""></a></li>
                                            </ul>
                                        </td>
                                    </tr>`
                                $("#data").append(output);
                            })

                        } else {
                            var output = `
                                    <tr>
                                        <td colspan="6" align="center">${response.message}</td>
                                    </tr>

                            `

                        }

                    }
                })
            }
            loadData();
        })
        
    </script>
@endsection
