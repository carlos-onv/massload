<?php


function core_get_filters( $hook = '' ) {
    global $wp_filter;
    if( empty( $hook ) || !isset( $wp_filter[$hook] ) ) return;

    $ret='';
    foreach($wp_filter[$hook] as $priority => $realhook){
        foreach($realhook as $hook_k => $hook_v){
            $hook_echo=(is_array($hook_v['function'])?get_class($hook_v['function'][0]).':'.$hook_v['function'][1]:$hook_v['function']);
            $ret.=  "\n$priority $hook_echo";
        }

    }
     return $ret;
}

function core_dump( $content = '', $args = array() ) {
    $default_args = array(
        'die' => false,
        'js'  => false,
    );

    $args = array_merge( $default_args, $args );
    extract( $args );

    if ( $js ) {
        echo '<script>';
            echo 'console.log('.json_encode( $content ).')';
        echo '</script>';
    } else {
        if ( !empty( $content ) ) {
            echo '<pre>';
                var_dump( $content );
            echo '</pre>';
        }
    }

    if ( $die ) {
        die();
    }

    return;
}

function core_print_r( $content = '', $args = array() ) {
    $default_args = array(
        'die' => false,
        'js'  => false,
    );

    $args = array_merge( $default_args, $args );
    extract( $args );

    if ( $js ) {
        echo '<script>';
            echo 'console.log('.json_encode( $content ).')';
        echo '</script>';
    } else {
        if ( !empty( $content ) ) {
            echo '<pre>';
                print_r( $content );
            echo '</pre>';
        }
    }

    if ( $die ) {
        die();
    }

    return;
}
