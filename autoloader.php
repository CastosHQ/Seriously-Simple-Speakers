<?php

spl_autoload_register( function ( $class ) {
	$file_path = explode( '\\', $class );

	foreach ( $file_path as $k => $v ) {
		$v               = mb_strtolower( str_replace( '_', '-', $v ) );
		$file_path[ $k ] = $v;
	}

	$file_name = end( $file_path );

	$file_name = 'class-' . $file_name . '.php';

	$file_path[ count( $file_path ) - 1 ] = $file_name;

	if ( 'ssspeakers' === $file_path[0] ) {
		$file_path[0] = 'includes';
	}

	$fully_qualified_path = trailingslashit( __DIR__ ) . implode( '/', $file_path );

	if ( stream_resolve_include_path( $fully_qualified_path ) ) {
		include_once $fully_qualified_path;
	}
} );
