<div class="modal fade" tabindex="-1" id="errors">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                ERRORS
            </div>
            <div class="modal-body">
                <div class="mt-2 mb-2 mr-3 ml-3">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>