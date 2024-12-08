<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4 shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Employee Registration</h4>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="bi bi-database-add"></i> ADD
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="display">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table rows will be populated dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to Add New Employee -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="employee-form" method="post">
                        @csrf  <!-- CSRF tokenini qo'shish -->
                        <div class="row">
                            <div class="col-lg">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="col-lg">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="employee-form">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to Edit Employee -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-form" method="post">
                        @csrf <!-- CSRF tokenini qo'shish -->
                        <input type="hidden" id="edit-id" name="id">
                        <div class="row">
                            <div class="col-lg">
                                <label for="edit-name">Name</label>
                                <input type="text" id="edit-name" name="name" class="form-control" required>
                            </div>
                            <div class="col-lg">
                                <label for="edit-email">Email</label>
                                <input type="email" id="edit-email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <label for="edit-address">Address</label>
                                <input type="text" id="edit-address" name="address" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <label for="edit-phone">Phone</label>
                                <input type="text" id="edit-phone" name="phone" class="form-control" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="edit-form">Update</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTable
            var table = $('#myTable').DataTable({
                "ajax": {
                    "url": "{{ route('getall') }}",
                    "type": "GET",
                    "dataType": "json",
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "dataSrc": function (response) {
                        if (response.status === 200) {
                            return response.employees;
                        } else {
                            return [];
                        }
                    }
                },
                "columns": [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "email" },
                    { "data": "address" },
                    { "data": "phone" },
                    {
                        "data": null,
                        "render": function (data, type, row) {
                            return '<a href="#" class="btn btn-sm btn-success edit-btn" data-id="'+data.id+'" data-name="'+data.name+'" data-email="'+data.email+'" data-address="'+data.address+'" data-phone="'+data.phone+'">Edit</a> ' +
                            '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="'+data.id+'">Delete</a>';
                        }
                    }
                ]
            });

            // Handle Edit Button
            $('#myTable tbody').on('click', '.edit-btn', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var email = $(this).data('email');
                var address = $(this).data('address');
                var phone = $(this).data('phone');
              
                $('#edit-id').val(id);
                $('#edit-name').val(name);
                $('#edit-email').val(email);
                $('#edit-address').val(address);
                $('#edit-phone').val(phone);
                $('#editModal').modal('show');
            });

            // Handle Save New Employee
            $('#employee-form').submit(function (e) {
                e.preventDefault();
                const employeedata = new FormData(this);

                $.ajax({
                    url: '{{ route('store') }}',
                    method: 'POST',
                    data: employeedata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 200) {
                            alert("Employee added successfully.");
                            $('#employee-form')[0].reset();
                            $('#exampleModal').modal('hide');
                            table.ajax.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + xhr.responseText);
                    }
                });
            });

            // Handle Update Employee
            $('#edit-form').submit(function (e) {
                e.preventDefault();
                const employeeData = new FormData(this);

                $.ajax({
                    url: '{{ route('update') }}',
                    method: 'POST',
                    data: employeeData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 200) {
                            alert("Employee updated successfully.");
                            $('#edit-form')[0].reset();
                            $('#editModal').modal('hide');
                            table.ajax.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + xhr.responseText);
                    }
                });
            });

            // Handle Delete Employee
            $('#myTable tbody').on('click', '.delete-btn', function () {
                if (confirm('Are you sure you want to delete this employee?')) {
                    var id = $(this).data('id');
                    $.ajax({
                        url: '{{ route('delete') }}',
                        method: 'POST',
                        data: {
                            id: id,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                alert("Employee deleted successfully.");
                                table.ajax.reload();
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("Error: " + xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
