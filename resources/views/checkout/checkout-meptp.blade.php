<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <script type="text/javascript" src="https://remitademo.net/payment/v1/remita-pay-inline.bundle.js"></script>
</head>
<body onload="makePayment()">
    <!-- <button onclick="makePayment()">click</button> -->
    <h4>Don't refresh page or close</h4>
<script>
    function makePayment() {
        var paymentEngine = RmPaymentEngine.init({
            key: '<?php echo env('REMITA_KEY') ?>',
            customerId: '<?php echo $user->id ?>',
            firstName: '<?php echo $user->firstname ?>',
            lastName: '<?php echo $user->lastname ?>',
            email: '<?php echo $user->email ?>',
            amount: '<?php echo $amount ?>',
            narration: '<?php echo env('REMITA_NARRATION') ?>',
            onSuccess: function(response) {
                console.log('callback Successful Response', response);
                var param = '?am=' + response.amount + '&ref=' + response.paymentReference;
                window.location.href = "{{ route('payment-success', $token) }}" + param;
            },
            onError: function(response) {
                console.log('callback Error Response', response);
                var param = '?am=' + response.amount + '&ref=' + response.paymentReference;
                window.location.href = "{{ route('payment-failed', $token) }}" + param;
                // window.location.href = "{{ route('payment-failed', $token) }}";
            },
            onClose: function(response) {
                console.log('callback Close Response', response);
                setTimeout(function(){ 
                    window.location.href = "{{ route('payment-failed', $token) }}";
                }, 2000);
            }
        });
        paymentEngine.showPaymentWidget();
    }
</script>
</body>
</html>
