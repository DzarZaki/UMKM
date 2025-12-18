<div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sudah selesai?</h5>
                <button class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                Pilih "Logout" untuk mengakhiri sesi.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form method="POST" action="/logout">
                    @csrf
                    <button class="btn btn-primary">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
