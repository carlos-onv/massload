<?php



function core_encapsulate_text( $args = array() ) {
    $output       = '';
    $default_args = array(
        'text'          => '',
        'word_position' => 0,
        'before'        => '<span>',
        'after'         => '</span>',
    );

    $args = array_merge( $default_args, $args );
    extract( $args );

    if ( ! empty( $text ) ) {
        $text                   = preg_split( "/\s+/", $text );
        $text[ $word_position ] = $before . $text[ $word_position ] . $after;

        $text = join(" ", $text);
    }

    return $text;
}

function core_sanitize_text( $string = '', $separator = '-' ) {
    $sanitize_text = '';

    if ( ! empty( $string ) ) { 

        // Removes special chars, but allows hyphens and underscore
        $sanitize_text = preg_replace( '/[^ \w-]/', '', $string ); 
        
        // Converts whitespace to the value of $separator
        $sanitize_text = preg_replace( '/\s+/', $separator, $sanitize_text );
    }

    return $sanitize_text;
}

function core_text_to_attr( $string = '', $separator = '_' ) {
    $format_text = '';

    if ( ! empty( $string ) ) {
        $string       = strtolower( $string );

        $format_text = core_sanitize_text( $string );
    }

    return $format_text;
}