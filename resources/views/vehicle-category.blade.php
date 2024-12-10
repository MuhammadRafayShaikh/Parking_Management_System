@extends('master')

@section('content')
    <div class="message"></div>
    <div class="container">
        <div class="admin-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="d-inline">Vehicle Category List</h2>
                    <a href="{{ route('addCategory') }}" class="btn btn-dark float-right m-2">Add New Category</a>
                    <a href="{{ route('pdf6') }}" class="btn btn-warning float-right m-2">Download PDF</a>
                </div>

                <div class="card-body position-relative">
                    <div id="table-data">

                        <table class="table-data table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>S.No</th>
                                    <th>Category Name</th>
                                    <th>Parking Charges</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="data">

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>

                                        <span class="badge badge-success">
                                            Active
                                        </span>

                                        <span class="badge badge-danger">
                                            Inactive
                                        </span>
                                    </td>
                                    <td>
                                        <ul class="action-list">
                                            <li><a href="update-vehicle-category.php?vcid="
                                                    class="btn btn-primary btn-sm"><img src="images/edit.png"
                                                        alt=""></a></li>
                                            <li><a href="#" data-vcid=""
                                                    class="btn btn-danger btn-sm delete-category"><img
                                                        src="images/delete.png" alt=""></a></li>
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
    <script src="assets/js/jquery.js" charset="utf-8"></script>
    <script src="assets/js/admin.js" charset="utf-8"></script>
    <script>
        $(document).ready(function() {
            function loadData() {
                const api_token = localStorage.getItem('api_token');
                $.ajax({
                    url: 'api/category',
                    type: 'GET',
                    headers: {
                        'Authorization': `Bearer ${api_token}`
                    },
                    success: function(response) {
                        console.log(response);
                        $("#data").empty();
                        $.each(response.category, function(key, value) {
                            let statusBadge = '';
                            if (value.category_status == 1) {
                                statusBadge = `<span class="badge badge-success">Active</span>`;
                            } else {
                                statusBadge =
                                    `<span class="badge badge-danger">Inactive</span>`;
                            }

                            // Laravel route URL generation manually in JavaScript
                            const editUrl = `/editCategory/${value.id}`;

                            const output = `
                        <tr>
                            <td>${value.id}</td>
                            <td>${value.category_name}</td>
                            <td>${value.parking_charge}</td>
                            <td>${statusBadge}</td>
                            <td>
                                <ul class="action-list">
                                    <li><a href="${editUrl}" class="btn btn-primary btn-sm"><img src="images/edit.png" alt=""></a></li>
                                    <li><a href="#" data-vcid="${value.id}" class="btn btn-danger btn-sm delete-category"><img src="images/delete.png" alt=""></a></li>
                                </ul>
                            </td>
                        </tr>
                    `;
                            $("#data").append(output);
                        });
                    }
                });
            }

            loadData();




        });
    </script>
@endsection
