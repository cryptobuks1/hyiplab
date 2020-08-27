@if(session()->has('error'))
    <div class="alert alert-danger" role="alert">
        <div class="iq-alert-icon">
            <i class="ri-information-line"></i>
        </div>
        <div class="iq-alert-text">{{ session('error') }}</div>
    </div>
@endif

@if(session()->has('success'))
<div class="alert alert-success" role="alert">
    <div class="iq-alert-icon">
        <i class="ri-alert-line"></i>
    </div>
    <div class="iq-alert-text">{{ session('success') }}</div>
</div>
@endif