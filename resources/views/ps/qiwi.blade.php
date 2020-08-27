<form method='get' action='https://www.free-kassa.ru/merchant/cash.php' id="payment" style="display:none;">
    <input type='hidden' name='m' value='<?=$merchantId?>'>
    <input type='hidden' name='oa' value='<?=$amount?>'>
    <input type='hidden' name='o' value='<?=$orderId?>'>
    <input type='hidden' name='s' value='<?=$signature?>'>
    <input type='hidden' name='lang' value='ru'>
    <input type='hidden' name='us_login' value='<?=$user->login?>'>
    <input type='hidden' name='i' value='63'>
    <input type='submit' name='pay' value='{{ __('Pay') }}'>
</form>

<script>
    document.forms.payment.submit()
</script>
