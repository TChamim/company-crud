<div class="modal fade" id="editCompanyModal" tabindex="-1" aria-labelledby="editCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editCompanyForm" method="POST" enctype="multipart/form-data" action="{{ route('companies.update', 'company_id_placeholder') }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editCompanyModalLabel">Edit Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="edit_website" class="form-label">Website</label>
                        <input type="url" class="form-control" id="edit_website" name="website">
                    </div>
                    <div class="mb-3">
                        <label for="currentLogo" class="form-label">Current Logo</label>
                        <div id="currentLogoContainer" style="display:none;">
                            <img id="currentLogo" src="" alt="Current Logo" width="100">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_logo" class="form-label">Logo</label>
                        <input type="file" class="form-control" id="edit_logo" name="logo">
                    </div>
                    <input type="hidden" id="edit_company_id" name="company_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
