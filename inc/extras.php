<?php
/**
 * Wrapper function for WP_Query.
 *
 * @param array  $args  The array configuration.
 *
 * @link   https://codex.wordpress.org/Class_Reference/WP_Query
 * @since  1.0.0
 *
 * @return object $query Returns object containing an array of $post objects.
 */


function core_wp_query( $args = array() ) {

    $default_args = array(
        'post_type'      => '',
        'posts_per_page' => -1,
        'order'          => 'ASC',
        'orderby'        => 'name',
    );

    $merged_args = array_merge( $default_args, $args );

    $query = new WP_Query( $merged_args );

    return $query;
}

/**
 * Get the excerpt of a content of a post.
 *
 * @param int    $id      The ID of post
 * @param string $content The content
 * @param int    $count   The excerpt count
 *
 * @since 1.0.0
 *
 * @return string $excerpt The excerpt content.
 */
function core_get_excerpt( $id = '', $content = '', $readmore = true, $enable_ellipsis = true, $count = '', $ellipsis = '... ' ) {
    if ( empty( $id ) ) {
        $id = get_the_ID();
    }
    if ( empty( $content ) ) {
        $content = get_the_content();
    }
    if ( empty( $count ) ) {
        $count = 22;
    }

    $count = intval( $count );

    if ( !empty( $content ) ) {
        $permalink = get_permalink( $id );

        if ( 'none' === $count ) {
            $excerpt = $content;
        } else {
            // $excerpt   = $content;
            // $excerpt   = strip_tags( $excerpt );
            // $excerpt   = substr( $excerpt, 0, $count );
            // $excerpt   = substr( $excerpt, 0, strripos( $excerpt, " " ) );
            $excerpt   = $content;
            $excerpt   = strip_tags( $excerpt );
            $excerpt   = core_do_excerpt( $excerpt, $count );
        }

        if ( $enable_ellipsis ) {
            $excerpt .= $ellipsis;
        }
        
        $excerpt = '<p class="content-excerpt">' . $excerpt . '</p>';

        if ( $readmore ) {
            $excerpt .= '<a class="core-readmore theme-btn" href="' . esc_url( $permalink ) . '">READ MORE</a>';
        }

        return $excerpt;
    }
}

/**
 * Checks if the variable is set. Sets the value for a variable if not set.
 *
 * @param array $item    The array value of the variable.
 * @param mixed $index   The index of the array.
 * @param mixed $default The default value of the variable.
 *
 * @since 1.0.0
 *
 * @return mixed $result  Returns the set value for a variable.
 *
 */
function core_isset_array( $item = array(), $index = '', $default ) {

    $result = '';

    if ( !empty( $index ) ) {
        if ( isset( $item[ $index ] ) ) {
            $result = core_isset_val( $item[ $index ], $default );
        } else {
            $result = $default;
        }
    }

    return $result;
}

/**
 * Checks if the variable is set. Sets the value for a variable if not set.
 *
 * @param mixed $item    The value of the variable.
 * @param mixed $default The default value of the variable.
 *
 * @since 1.0.0
 *
 * @return mixed $result  Returns the set value for a variable.
 *
 */
function core_isset_val( $item, $default ) {

    $result = '';

    if ( isset( $item ) ) {
        $result = $item;
    } else {
        $item = $default;
    }

    return $result;
}

function core_do_excerpt( $string = '', $wordsreturned = 25 ) {
    if ( ! empty( $string ) ) {
        $retval = $string;  //  Just in case of a problem
        $array = explode(" ", $string);
        /*  Already short enough, return the whole thing*/
        if ( count( $array ) <= $wordsreturned ) {
            $retval = $string;
        } else {
            /*  Need to chop of some words*/
            array_splice($array, $wordsreturned);
            $retval = implode( " ", $array );
        }
        return $retval;
    }
}
  