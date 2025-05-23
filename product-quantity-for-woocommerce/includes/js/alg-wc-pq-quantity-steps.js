/**
 * alg-wc-pq-quantity-steps.js
 *
 * @version 5.0.7
 * @since   4.6.10
 * @todo    Step Quanity > Allow adding all quantity in stock (skip step restriction)
 */

jQuery( document ).ready( function () {

	function manage_skip_step_restriction( input ) {
		let lastValue = '';
		let originalMin = input.min;
		let originalMax = input.max;
		let originalStep = input.step;
		let lastPossibleValue = '';

		input.addEventListener( 'beforeinput', ( e ) => {
			let targetInput = e.target;
			if ( parseFloat( lastValue ) === parseFloat( e.data ) ) {
				input.dataset.skipMode = 'skip';
				targetInput.step = '';
				targetInput.min = 0;
				lastPossibleValue = targetInput.value;
				targetInput.value = originalMax;
			} else {
				input.dataset.skipMode = '';
				targetInput.step = originalStep;
				targetInput.min = originalMin;
			}
			if ( 'skip' !== targetInput.dataset.skipMode && targetInput.value == originalMax ) {
				input.dataset.skipMode = 'lastPossibleValue';
			}
			lastValue = parseFloat( e.data );
		} );

		input.addEventListener( 'change', ( e ) => {
			let targetInput = e.target;
			if ( 'skip' === targetInput.dataset.skipMode ) {
				targetInput.min = 0;
				targetInput.value = originalMax;
				lastValue = targetInput.value;
			} else if ( 'lastPossibleValue' === targetInput.dataset.skipMode && lastPossibleValue>0) {
				targetInput.value = lastPossibleValue;
				lastValue = targetInput.value;
			}
		} )
	}

	if ( alg_wc_pq_support_runtime_steps.page == 'product' ) {
		const input = document.querySelector( '[name="quantity"]' );
		manage_skip_step_restriction(input);
	}

	if ( alg_wc_pq_support_runtime_steps.page == 'cart' ) {
		data_loop = alg_wc_pq_support_runtime_steps.data;
		console.log(data_loop)
		for ( const key in data_loop ) {
			var cart_field_name = `cart[${ key }][qty]`;
			const inputs = document.querySelectorAll('[name="' + cart_field_name + '"]');
			//const inputs = document.querySelectorAll('.wc-block-components-quantity-selector__input');
			console.log(inputs)
			inputs.forEach(input => {
				manage_skip_step_restriction(input);
			});
		}
	}
} );