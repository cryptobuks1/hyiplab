<div class="modal fade bd-welcome-demo" tabindex="-1" role="dialog" aria-hidden="true" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color:black;">{{ __('Welcome') }}!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-dark">
                    <tbody>
                    <tr>
                        <td style="font-weight: bold;">{{ __('Main_website') }}</td>
                        <td style="width:150px;">
                            <a href="{{ route('customer.main') }}" class="btn btn-primary" target="_blank">{{ __('open') }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">{{ __('Admin_panel') }}</td>
                        <td style="width:150px;">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary" target="_blank">{{ __('open') }}</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">{{ __('Ok') }}</button>
            </div>
        </div>
    </div>
</div>