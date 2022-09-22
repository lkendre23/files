<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );


// replaceing the select box -- to values in contact form 7 
function my_wpcf7_form_elements($html) {
    $text = 'Designing & Branding';
    $html = str_replace('<option value="">---</option>', '<option value="'.$text.'">' . $text . '</option>', $html);
    return $html;
}
add_filter('wpcf7_form_elements', 'my_wpcf7_form_elements');



// Case Study filter
// Case Study filter

add_action('wp_ajax_nopriv_casestudy_action','caseStudy_fetch');
add_action('wp_ajax_casestudy_action','caseStudy_fetch');

function caseStudy_fetch(){
    $cat_id = (!empty($_POST['cat_type']))?sanitize_text_field($_POST['cat_type']): '';
    $custome_post = (!empty($_POST['custome_post']))? sanitize_text_field($_POST['custome_post']) : '';
    
    if( ( !empty($cat_id) ) && ( !empty($custome_post) )){
        $args =  array(
                'post_type' => 'cb_casestudies',
                'posts_per_page' => -1,
                'order' => 'DESC',              
                'meta_query' => array(                    
                    'relation' => 'AND',
                    array(
                        'key' => 'select_filed',
                        'value' => $custome_post,
                        'compare' => 'LIKE',
                        'field'   => 'title',
                        )
                    ),                
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'casestudies_category',
                        'field' => 'term_id',
                        'terms' => $cat_id
                    ),                   
                ),
                
                

        );                
         $getPosts = new WP_Query($args);           
    }
    
    if( ( !empty($cat_id) )  && ( empty($custome_post) ) ){
        $args = array(
            'post_type' => 'cb_casestudies',
            'posts_per_page' =>  -1,
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'casestudies_category',
                    'field' => 'term_id',
                    'terms' => $cat_id,
                )
            )
        );
        $getPosts = new WP_Query($args);       
    }

    
    if(  ( !empty($custome_post) )  &&  ( empty($cat_id) )  ){
       
        $args = array(
            'post_type' => 'cb_casestudies',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'meta_value' => $custome_post,            
        );
        
        $getPosts = new WP_Query($args);       
    }
        
    $post_count = $getPosts->post_count;
    if($post_count == 0) {
        $result = [
        'status' => 'error',        
        'msg' => ( 'No Result found' ),        
        ];

        wp_send_json($result);
        wp_die();    
    }

    $posts = [];
     if ( $getPosts->have_posts() ) { 
      while ($getPosts->have_posts()) {
            $getPosts->the_post();                       

    $posts[] = array(
        'title' => get_the_title(),
        'contents' => get_the_content(),
        
    );

    }
}
    $result = [
        'status' => 'success',
        'response_type' => 'get posts',
        'msg' => 'results',        
        'data' => $posts,              
    ];
    wp_send_json($result);
    wp_die();


}

// Case Study filter
// Case Study filter
 

// Search Blogs
// Search Blogs
add_action('wp_ajax_nopriv_my_action', 'data_fetch');
add_action('wp_ajax_my_action', 'data_fetch');

function data_fetch(){
    
    $search = (!empty($_POST['search']) )? sanitize_text_field($_POST['search']) : ''; 
    $post_type = (!empty($_POST['post_type']) )? sanitize_text_field($_POST['post_type']) : '';   
    $post_cat_id = (int)$post_type;

    $no_post = (!empty($_POST['number']) )? sanitize_text_field($_POST['number']) : '';   
    $no_post = (int)$no_post;

    // echo gettype($post_cat_id);
    // exit();
    if( empty($search) && empty($post_cat_id) ){
        
        $args =  array(
                'post_type' => 'post',
                'posts_per_page' => $no_post,
                'order' => 'DESC',              

            );

    $getPosts = new WP_Query($args);
    }

    if( !empty($search) || !empty($post_cat_id) ){
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $no_post,
            'order' => 'DESC',
            's' => $search,
            'tax_query' => array(
                 'relation' => 'AND',
                    array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $post_cat_id
                ),
            ),
        );
        $getPosts = new WP_Query($args);
    }  


     if( !empty($post_cat_id) ){
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $no_post,
            'order' => 'DESC',            
            'tax_query' => array(                 
                    array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $post_cat_id
                ),
            ),
        );
        $getPosts = new WP_Query($args);
    } 

     if( !empty($search) ){
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $no_post,
            'order' => 'DESC',
            's' => $search,
            // 'tax_query' => array(
            //      'relation' => '',
            //         array(
            //         'taxonomy' => 'category',
            //         'field'    => 'term_id',
            //         'terms'    => $post_cat_id
            //     ),
            // ),
        );
        $getPosts = new WP_Query($args);
    } 

    $post_count = $getPosts->post_count;
    if($post_count == 0) {
        $result = [
        'status' => 'error',        
        'msg' => ( 'No Result found' ),        
        ];

        wp_send_json($result);
        wp_die();    
    }

    $posts = [];
     if ( $getPosts->have_posts() ) { 
      while ($getPosts->have_posts()) {
            $getPosts->the_post();                       

    $posts[] = array(
        'title' => get_the_title(),
        'contents' => get_the_content(),
        
    );

    }
}
    $result = [
        'status' => 'success',
        'response_type' => 'get posts',
        'msg' => 'results',        
        'data' => $posts,              
    ];
    wp_send_json($result);
    wp_die();
    
}
// Search Blogs
// Search Blogs
