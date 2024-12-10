@extends('master')

@section('content')
    <div class="message"></div>
    <div class="container">
        <div class="admin-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="d-inline">Add Vehicle Category</h2>
                    <a href="vehicle-category.php" class="btn btn-success float-right">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                        </svg>
                        Vehicle Category List
                    </a>
                </div>
                <div class="card-body position-relative">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="category_name" class="form-control cat_name" placeholder="Name"
                            name="cat_name" value="" required>
                    </div>
                    <div class="form-group">
                        <label>Parking Charges Per Hour</label>
                        <input type="number" id="category_charges" class="form-control parking_charge"
                            placeholder="Parking Charges Per Hour" name="parking_charge" value="" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control cat_status" name="category_status" id="category_status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <input type="submit" name="save" class="btn btn-dark float-right" id="add" value="Save"
                        required>

                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $("#add").on('click', function(e) {
            e.preventDefault();

            var category_name = $("#category_name").val();
            var category_charges = $("#category_charges").val();
            var category_status = $("#category_status").val();

            const api_token = localStorage.getItem('api_token');

            var formData = new FormData();

            formData.append('category_name', category_name)
            formData.append('parking_charge', category_charges)
            formData.append('category_status', category_status)

            // formData.append ka pehla parameter database k table k column ka name hona chayea agar same nhi hoga to Unauthorized ka error ayega

            $.ajax({
                url: 'api/category',
                type: 'POST',
                data: formData,
                headers: {
                    'Authorization': 'Bearer ' + api_token,
                },
                contentType: false,
                processData: false,
                success: function(response) {
                    // console.log(response);
                    alert('Successfully Added' + ' ' + response.category)
                    window.location.href = '/vehicle-category'
                },
                error: function(xhr, status, error) {
                    console.log("Error:", error);
                    $(".message").html(
                        "<div class='alert alert-danger'>An error occurred</div>");
                }
            })
        })
    })
</script>
