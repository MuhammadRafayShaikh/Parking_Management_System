@extends('master')

@section('content')
    <div class="message"></div>
    <div class="container">
        <div class="admin-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="d-inline">Vehicle List</h2>
                    <a href="{{ route('addVehicle') }}" class="btn btn-dark float-right m-2">Add New Vehicle</a>
                    <a href="{{ route('pdf2') }}" class="btn btn-warning float-right m-2">Download PDF</a>
                </div>

                @if (session('status'))
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-center text-success">{{ session('status') }}</div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-center text-danger">{{ session('error') }}</div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card-body position-relative">
                    <div id="table-data">

                        <table class="table-data table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>S.No</th>
                                    <th>Parking No.</th>
                                    <th>Category Name</th>
                                    <th>Owner Name</th>
                                    <th>Vehicle Reg Number</th>
                                    <th>Vehicle InTime</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="data">

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <br>
                                        <small></small>
                                    </td>
                                    <td>

                                        <span class="badge badge-info">Vehicle In</span>

                                    </td>
                                    <td>
                                        <ul class="action-list">
                                            <li><a href="view-vehicle.php?veid=" class="btn btn-primary btn-sm"><img
                                                        src="images/eye.png" alt=""></a></li>
                                        </ul>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Include Moment.js -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

    <script>
        $(document).ready(function() {
            function loadData() {
                const api_token = localStorage.getItem('api_token');

                $.ajax({
                    url: 'api/vehicles',
                    type: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + api_token
                    },
                    success: function(response) {
                        // console.log(response);

                        $("#data").empty();
                        $.each(response.vehicles, function(key, value) {
                            var url = `view-vehicle/${value.id}`
                           
                            var date = moment(value.intime).format('YYYY-MM-DD');
                            var time = moment(value.intime).format('HH:mm:ss');

                            var output = `

                                 <tr>
                                     <td>${value.id}</td>
                                     <td>${value.parking_number}</td>
                                     <td>${value.category.category_name}</td>
                                     <td>${value.owner_name}</td>
                                     <td>${value.registration_number}</td>
                                     <td>
                                         <span>${date}</span>
                                         <br>
                                         <small>${time}</small>
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
                                 </tr>

                            `
                            $("#data").append(output)
                        })
                    }
                })
            }

            loadData();
        })
    </script>
@endsection
