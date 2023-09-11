<div id="productApproveModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="groupModalLabel">Product Requests List</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-5">
                        <label for="group_name" class="form-label">Name <sup class="text-danger">*</sup></label>
                        <input type="text" name="name" id="group_name" value="{{ old('name') }}"
                            class="form-control" placeholder="Enter group name" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="button" onclick="submitGroupForm()" class="btn btn-primary ms-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

