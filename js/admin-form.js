// js/admin-form.js

jQuery( document ).ready( function() {
	if ( tcc_admin_options.showhide ) {
		jQuery.each( tcc_admin_options.showhide, function( counter, item ) {
			if ( targetableElement( item ) ) {
				let origin = '.' + item.origin + ( ( item.render === 'select' ) ? ' select' : ' input:radio' );
				jQuery( origin ).change( item, function( e ) {
					targetableElement( e.data );
				});
			}
		});
	}
});

function targetableElement( item ) {
	if ( item.origin && item.target ) {
		let query  = '.' + item.origin + ( ( item.render === 'select' ) ? ' select option:selected' : ' input:radio:checked' );
		let result = jQuery( query );
		if ( result.length ) {
			let state = jQuery( result ).val();
			if ( state ) {
				let target = '.' + item.target;
				if ( item.show ) {
					if ( state === item.show ) {
						jQuery( target ).parent().parent().show( 1500 ); //removeClass('hidden');
					} else {
						jQuery( target ).parent().parent().hide( 1500 ); //addClass('hidden');
					}
				} else if ( item.hide ) {
					if ( state === item.hide ) {
						jQuery( target ).parent().parent().hide( 1500 ); //addClass('hidden');
					} else {
						jQuery( target ).parent().parent().show( 1500 ); //removeClass('hidden');
					}
				}
			}
			return query;
		}
	}
	return false;
}
