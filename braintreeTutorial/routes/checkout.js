const express = require('express');
const router = express.Router();
const braintree = require('braintree');

router.post('/', (req, res) => {
  const gateway = new braintree.BraintreeGateway({
    environment: braintree.Environment.Sandbox,
    merchantId: 'xsf6sxhgjmrcrxm9',
    publicKey: 'g5qrd5bjshn6kgss',
    privateKey: '15f7c8cb0c92f9e476217745deb1e8b7'
  });

  const nonceFromTheClient = req.body.paymentMethodNonce;

  const newTransaction = gateway.transaction.sale({
    amount: '10.00',
    paymentMethodNonce: nonceFromTheClient,
    options: {
      submitForSettlement: true
    }
  }, (error, result) => {
    if (result) {
      res.send(result);
    } else {
      res.status(500).send(error);
    }
  });
});

module.exports = router;
