<?php

namespace SSSpeakers;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Renderer {
	public static function render( $template_path, $data ) {
		extract( $data, EXTR_OVERWRITE );
		ob_start();

		$template_file = SSS_PLUGIN_PATH . 'templates/' . $template_path . '.php';
		include $template_file;

		$template_content = ob_get_clean();

		$template_content = apply_filters( 'sss_render_template', $template_content );

		return $template_content;
	}
}
