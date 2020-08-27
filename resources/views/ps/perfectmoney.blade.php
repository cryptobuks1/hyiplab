<form id="payment" method="POST" action="https://perfectmoney.is/api/step1.asp"
      style="display:none;">
    <input type="hidden" name="PAYEE_ACCOUNT" value="{{ $payeeAccount }}">
    <input type="hidden" name="PAYEE_NAME" value="{{ $payeeName }}">
    <input type="hidden" name="PAYMENT_ID" value="{{ strtoupper($paymentId) }}">
    <input type="hidden" name="PAYMENT_AMOUNT" value="{{ $amount }}">
    <input type="hidden" name="PAYMENT_UNITS" value="{{ $currency }}">
    <input type="hidden" name="STATUS_URL" value="{{ $statusUrl }}">
    <input type="hidden" name="PAYMENT_URL"
           value="{{ route('account.make-deposit', ['result' => 'ok']) }}">
    <input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
    <input type="hidden" name="NOPAYMENT_URL"
           value="{{ route('account.make-deposit', ['result' => 'error']) }}">
    <input type="hidden" name="NOPAYMENT_URL_METHOD" value="POST">
    <input type="hidden" name="SUGGESTED_MEMO" value="{{ $comment }}">

    <!-- Merchant custom fields -->
    <input type="hidden" name="userid" value="{{ $user->id }}">
    <input type="hidden" name="walletid" value="{{ $wallet->id }}">
    <input type="hidden" name="BAGGAGE_FIELDS" value="userid walletid">
    <input type="submit" name="PAYMENT_METHOD" value="Pay Now!">
</form>

<script>
    document.forms.payment.submit()
</script>