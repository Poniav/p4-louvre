$(document).ready(function () {

    var stripe = Stripe(stripekey);

    var elements = stripe.elements();

    var style = {
        iconStyle: 'solid',
        base: {
            color: '#32325d',
            lineHeight: '18px',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            ':-webkit-autofill': {
                color: '#fce883'
            },
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    var cardNumber = elements.create('cardNumber', {style: style});
    cardNumber.mount('#cc-name');

    var cardExpiry = elements.create('cardExpiry', {style: style});
    cardExpiry.mount('#cc-expiry');

    var cardCvc = elements.create('cardCvc', {style: style});
    cardCvc.mount('#cc-ccv');

    // var card = elements.create('card', {style: style});
    // card.mount('#card-element');

    function stripeTokenHandler(token) {

        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        form.submit();
    }

    // card.addEventListener('change', function(event) {
    //     var displayError = document.getElementById('card-errors');
    //     if (event.error) {
    //         displayError.textContent = event.error.message;
    //     } else {
    //         displayError.textContent = '';
    //     }
    // });

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(cardNumber, cardExpiry, cardCvc).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server.
                stripeTokenHandler(result.token);
            }
        });
    });
});
