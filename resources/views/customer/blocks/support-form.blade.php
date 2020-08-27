<form action="{{ route('support.handle') }}" method="POST" target="_top">
    {{ csrf_field() }}

    <div class="row">
        <div class="col-lg-12">
            <div class="form-pos">
                <div class="form-group i-name">

                    <input type="text" class="form-control require" name="name" required="" placeholder="{{ __('Fullname') }}">

                </div>
            </div>
        </div>
        <!-- /.col-md-12 -->
        <div class="col-lg-6 col-md-6">
            <div class="form-e">
                <div class="form-group i-email">
                    <label class="sr-only">{{ __('Email') }} </label>
                    <input type="email" class="form-control require" name="email" required="" placeholder=" Email *" data-valid="email" data-error="{{ __('Enter_correct_email') }}">

                </div>
            </div>
        </div>
        <!-- /.col-md-12 -->
        <div class="col-lg-6 col-md-6">
            <div class="form-s">
                <div class="form-group i-subject">

                    <input type="text" class="form-control" name="subject" required="" placeholder="{{ __('Subject') }}">

                </div>
            </div>
        </div>
        <!-- /.col-md-12 -->
        <div class="col-md-12">
            <div class="form-m">
                <div class="form-group i-message">

                    <textarea class="form-control require" name="body" required="" rows="5" id="messageTen" placeholder="{{ __('Message') }}"></textarea>

                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="form-e">
                <div class="form-group i-email">
                    {!! captcha_img() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="form-e">
                <div class="form-group i-email">
                    <label class="sr-only">{{ __('Code_from_captcha') }} </label>
                    <input type="text" class="form-control require" name="captcha" required="" placeholder="{{ __('code') }} *">

                </div>
            </div>
        </div>
        <!-- /.col-md-12 -->
        <div class="col-md-12">
            <div class="tb_es_btn_div">
                <div class="response"></div>
                <div class="tb_es_btn_wrapper conatct_btn2 cont_bnt">
                    <button type="submit" class="submitForm">{{ __('Send_message') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>