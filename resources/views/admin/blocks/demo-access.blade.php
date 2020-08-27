<div class="modal fade bd-demo-access" tabindex="-1" role="dialog" aria-hidden="true" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color:black;">{{ __('Administrator_accesses') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-dark">
                    <tbody>
                    <tr>
                        <td style="font-weight: bold;">{{ __('Login') }}</td>
                        <td style="width:150px;">
                            <input type="text" class="form-control" value="demo" style="font-weight: bold; color:black;" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">{{ __('Password') }}</td>
                        <td style="width:150px;">
                            <input type="text" class="form-control" value="demo" style="font-weight: bold; color:black;" readonly>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <hr>
                <ul>
                    <li>{{ __('All_demo_data_are_overwritten_automatically_every_day') }}</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">{{ __('Ok') }}</button>
            </div>
        </div>
    </div>
</div>