<!-- Redirecting to our payment processor -->
<!-- This page exists to keep the order page load time low -->

<script src="https://js.stripe.com/v3/"></script>
<script>

	var stripe = Stripe('{!! config('stripe_keys.publish_key') !!}');

	stripe.redirectToCheckout({
		  // Make the id field from the Checkout Session creation API response
		  // available to this file, so you can provide it as parameter here
		  // instead of the CHECKOUT_SESSION_ID placeholder.
		  sessionId: '{{ $session->id }}'
		}).then(function (result) {
		  // If `redirectToCheckout` fails due to a browser or network
		  // error, display the localized error message to your customer
		  // using `result.error.message`.
		});
	
</script>