function makePayment() {
    var paymentEngine = RmPaymentEngine.init({
        key: 'UENOfDQwODE3MjIxfGVjZDIzMDU2M2IzMWRjMGQ2ZWY5OTFmZjdiZmE2OGNhOWJhYjg5MWRjYjYxZjNkNTYwZmM4MmMyMmIxNmUwMTBjYzFhZGViNjMwNDRmOWFiZWViNGIzMmVmODM5YzdiNTlmNjAyNzk2YmM3NmJjNGU2ZjgyODNiNTE2NWU3Nzc1',
        customerId: 'iampapaisarkar@gmail.com',
        firstName: 'papai',
        lastName: 'sarkar',
        email: 'iampapaisarkar@gmail.com',
        amount: 500,
        narration: 'Test',
        onSuccess: function(response) {
            console.log('callback Successful Response', response);
        },
        onError: function(response) {
            console.log('callback Error Response', response);
        },
        onClose: function() {
            console.log("closed");
        }
    });
    paymentEngine.showPaymentWidget();
}