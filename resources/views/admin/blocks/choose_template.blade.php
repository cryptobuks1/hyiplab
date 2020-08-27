@if(null == auth()->guard('admin')->user()->admin_template)
    <style>
        .doHover img {
            border:10px solid rgb(110,110,110);
            cursor: pointer;
        }
        .doHover img:hover {
            border-color: rgb(60,60,60);
        }
    </style>

    <div id="gridSystemModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true" style="width:100%;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gridModalLabel" style="color:black;">{{ __('Choose_color_scheme') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="iq-example-row">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6 doHover">
                                    <a href="{{ route('admin.choose_template', ['template' => 'dark']) }}">
                                        <img src="/admin_assets/images/templates/dark.png" style="max-width:100%; max-height:100%;">
                                    </a>
                                </div>
                                <div class="col-lg-6 doHover">
                                    <a href="{{ route('admin.choose_template', ['template' => 'light']) }}">
                                        <img src="/admin_assets/images/templates/light.png" style="max-width:100%; max-height:100%;">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('js')
        <script>
            $(document).ready(function(){
                $('#gridSystemModal').modal('show');
            });
        </script>
    @endsection
@endif