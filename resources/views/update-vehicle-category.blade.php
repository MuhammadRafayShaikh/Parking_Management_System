@extends('master')

@section('content')
    <div class="message"></div>
    <div class="container">
        <div class="admin-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="d-inline">Update Vehicle Category</h2>
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
                        <input type="hidden" id="category_id" name="category_id" value="{{ $cateogry->id }}">

                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="hidden" name="cat_id" value="" required>
                        <input type="text" class="form-control cat_name" placeholder="Name" id="category_name"
                            name="cat_name" value="{{ $cateogry->category_name }}" required>
                    </div>
                    <div class="form-group">
                        <label>Parking Charges Per Hour</label>
                        <input type="number" class="form-control parking_charge" id="category_charges"
                            placeholder="Parking Charges Per Hour" name="parking_charge"
                            value="{{ $cateogry->parking_charge }}" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control cat_status" name="cat_status" id="category_status">
                            <option value="1" {{ $cateogry->category_status == 1 ? 'selected' : '' }}>Active
                            </option>
                            <option value="0" {{ $cateogry->category_status == 0 ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>

                    <input type="submit" id="update" name="save" class="btn btn-dark float-right" value="Save"
                        required>


                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            const api_token = localStorage.getItem('api_token');
            console.log(api_token); // Isko check karne ke liye console me dekhein token sahi aa raha hai ya nahi

            $("#update").on('click', function(e) {
                e.preventDefault(); // Prevent the form from submitting normally
                var category_id = $("#category_id").val(); // get the hidden input value
                var category_name = $("#category_name").val();
                var category_charges = $("#category_charges").val();
                var category_status = $("#category_status").val();

                const api_token = localStorage.getItem('api_token');

                var formData = new FormData();
                formData.append('category_id', category_id);
                formData.append('category_name', category_name);
                formData.append('parking_charges', category_charges); // This should match the validation
                formData.append('category_status', category_status);


                $.ajax({
                    url: `/api/category/${category_id}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'Authorization': 'Bearer ' + api_token,
                        'X-HTTP-Method-Override': 'PUT',
                    },
                    success: function(response) {
                        console.log(response);
                        alert(response.message)
                        window.location.href = '/vehicle-category'
                        if (response.status) {
                            $(".message").html(
                                "<div class='alert alert-success'>Updated Successfully</div>"
                            );
                        } else {
                            $(".message").html(
                                "<div class='alert alert-danger'>Update Failed</div>");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error:", error);
                        $(".message").html(
                            "<div class='alert alert-danger'>An error occurred</div>");
                    }
                });


            });
        });
    </script>
@endsection
