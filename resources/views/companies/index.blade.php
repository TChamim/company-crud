@extends('layouts.layout')

@section('title', 'Company List')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Companies</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCompanyModal">Add Company</button>
    </div>

    <table class="table table-striped" id="companiesTable">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Website</th>
                <th scope="col">Logo</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
    </table>
</div>

@include('companies.create')
@include('companies.edit')
@include('companies.show')

<!-- Modal for delete confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this company?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        const table = $('#companiesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('companies.index') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'website', name: 'website' },
                { data: 'logo', name: 'logo', orderable: false, render: function(data) {
                    return data ? `<img src="{{ asset('storage') }}/${data}" alt="Logo" width="50">` : 'No Logo';
                }},
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // View company details
        $('#companiesTable').on('click', '.view-btn', function() {
            const id = $(this).data('id');
            $.get(`/companies/${id}`, function(company) {
                $('#viewCompanyName').text(company.name);
                $('#viewCompanyEmail').text(company.email || 'N/A');
                $('#viewCompanyWebsite').attr('href', company.website || '#').text(company.website || 'N/A');
                $('#viewCompanyLogo').attr('src', company.logo ? '{{ asset('storage') }}/' + company.logo : '');

                $('#viewCompanyModal').modal('show');
            });
        });

        // Edit company details
        $('#companiesTable').on('click', '.edit-btn', function() {
            const id = $(this).data('id');

            $.get(`/companies/${id}`, function(company) {
                $('#edit_company_id').val(company.id);
                $('#edit_name').val(company.name);
                $('#edit_email').val(company.email);
                $('#edit_website').val(company.website);

                $('#editCompanyForm').attr('action', '{{ url("companies") }}/' + company.id);

                if (company.logo) {
                    $('#currentLogo').attr('src', '{{ asset('storage') }}/' + company.logo);
                    $('#currentLogoContainer').show();
                } else {
                    $('#currentLogoContainer').hide();
                }
                
                $('#editCompanyModal').modal('show');
            }).fail(function() {
                alert('Error retrieving company data.');
            });
        });

        // Confirm delete action
        $('#companiesTable').on('click', '.delete-btn', function() {
            const deleteUrl = $(this).data('url');
            $('#deleteForm').attr('action', deleteUrl);
            $('#deleteModal').modal('show');
        });

        // Refresh DataTable after adding or editing a company
        function refreshTable() {
            table.ajax.reload(null, false); // The second parameter is for resetting the paging
        }

        // Handle the submission of the create and edit forms
        $('#addCompanyForm, #editCompanyForm').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const url = form.attr('action');
            const method = form.attr('method');

            $.ajax({
                url: url,
                method: method,
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    refreshTable();
                    form[0].reset(); // Reset the form
                    $('#addCompanyModal, #editCompanyModal').modal('hide'); // Close the modals
                    alert('Company saved successfully!'); // You can replace this with a better notification system
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            alert(value); // Show error messages; you can replace this with a better UI
                        });
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                }
            });
        });
    });
</script>
@endsection
