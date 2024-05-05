<?php
/*
Plugin Name: STFQ Asset Manager
Description: Manage digital assets like AI, EPS, and PDF documents.
Plugin URI: https://strangefrequency.com/wp-plugins/stfq-asset-manager/
Version: 1.0
Author: Strangefrequency LLC
Author URI: https://strangefrequency.com/
License: GPL-3.0-or-later
License URI: https://www.gnu.org/licenses/old-licenses/gpl-3.0.html
*/

// Register custom post type
function stfq_register_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'STFQ Assets',
        'supports' => array( 'title', 'editor', 'thumbnail'),
        'taxonomies' => array( 'asset_tags' ),
        'menu_icon' => 'dashicons-images-alt2',
    );
    register_post_type( 'stfq_asset', $args );
}
add_action( 'init', 'stfq_register_post_type' );

// Register custom taxonomy for asset tags
function stfq_register_taxonomy() {
    $args = array(
        'label' => 'Asset Tags',
        'rewrite' => array( 'slug' => 'asset-tag' ),
        'hierarchical' => true,
    );
    register_taxonomy( 'asset_tag', 'stfq_asset', $args );
}
add_action( 'init', 'stfq_register_taxonomy' );

// Add custom field to asset posts on plugin activation
function stfq_add_custom_field_on_activation() {
    // Define custom field key
    $custom_field_key = 'download_url';
    
    // Define custom field label
    $custom_field_label = 'Download URL';
    
    // Get all asset posts
    $assets_query = new WP_Query( array(
        'post_type' => 'stfq_asset',
        'posts_per_page' => -1, // Retrieve all assets
    ) );

    // Loop through asset posts
    while ( $assets_query->have_posts() ) {
        $assets_query->the_post();
        
        // Check if custom field already exists for this post
        $existing_value = get_post_meta( get_the_ID(), $custom_field_key, true );
        if ( empty( $existing_value ) ) {
            // Add custom field if not already present
            add_post_meta( get_the_ID(), $custom_field_key, '', true );
        }
    }
    
    // Reset post data
    wp_reset_postdata();
}
register_activation_hook( __FILE__, 'stfq_add_custom_field_on_activation' );

// Add meta boxes for additional information
function stfq_add_meta_boxes() {
    // Add the download URL meta box before the custom fields meta box
    add_meta_box( 'download_url', 'Download URL', 'stfq_download_url_meta_box', 'stfq_asset', 'normal', 'high' );
    add_meta_box( 'file_type', 'File Type', 'stfq_file_type_meta_box', 'stfq_asset', 'side', 'default' );
    // Add more meta boxes for additional information
}
add_action( 'add_meta_boxes', 'stfq_add_meta_boxes' );

// Function to display download URL meta box
function stfq_download_url_meta_box( $post ) {
    // Retrieve existing value of download URL
    $download_url = get_post_meta( $post->ID, 'download_url', true );
    ?>
    <label for="stfq_download_url">Download URL:</label><br>
    <input type="text" id="stfq_download_url" name="stfq_download_url" value="<?php echo esc_attr( $download_url ); ?>" style="width: 100%;" class="regular-text">
    <?php
}

// Save custom fields when asset is saved or updated
function stfq_save_custom_fields( $post_id ) {
    // Check if this is an autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check if current user has permissions to save post
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Check if download URL is set
    if ( isset( $_POST['stfq_download_url'] ) ) {
        // Sanitize and save download URL
        $download_url = sanitize_text_field( $_POST['stfq_download_url'] );
        update_post_meta( $post_id, 'download_url', $download_url );
    }

    // Check if file type is set
    if ( isset( $_POST['stfq_file_type'] ) ) {
        // Sanitize and save file type
        $file_type = sanitize_text_field( $_POST['stfq_file_type'] );
        update_post_meta( $post_id, 'file_type', $file_type );
    }
}
add_action( 'save_post', 'stfq_save_custom_fields' );

// Shortcode to display digital assets
function stfq_display_assets_shortcode( $atts ) {
    // Extract shortcode attributes
    $atts = shortcode_atts( array(
        'tags' => '', // Default to empty string
    ), $atts );

    // Parse tags attribute into an array
    $tags = explode( ',', $atts['tags'] );

    // Query digital assets based on tags, ordered alphabetically by title
    $assets_query = new WP_Query( array(
        'post_type' => 'stfq_asset',
        'posts_per_page' => -1, // Retrieve all assets
        'tax_query' => array(
            array(
                'taxonomy' => 'asset_tag',
                'field'    => 'slug',
                'terms'    => $tags,
            ),
        ),
        'orderby' => 'title', // Order by title
        'order'   => 'ASC',   // Ascending order
    ) );

    // Initialize output variable
    $output = '';

    // Check if assets were found
    if ( $assets_query->have_posts() ) {
        // Start output buffer
        ob_start();

        // Display assets loop
        echo '<div class="stfq-asset-grid">'; // Open the wrapper div
        while ( $assets_query->have_posts() ) {
            $assets_query->the_post();
            
            // Get thumbnail URL
            $thumbnail_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );
            $thumbnail_url = $thumbnail_url[0];
            ?>
            <div class="stfq-asset">
                <div class="stfq-asset-thumbnail">
                    <img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
                </div>
                <div class="stfq-asset-details">
                    <h4 class="stfq-asset-title"><?php the_title(); ?></h4>
					<hr />
                    <div class="stfq-asset-description">
                        <?php the_content(); ?>
						<div class="stfq-asset-file-type"><?php echo get_post_meta( get_the_ID(), 'file_type', true ); ?></div>
                    </div>
                    <div class="stfq-asset-download-link">
                        <?php $download_url = get_post_meta( get_the_ID(), 'download_url', true );
                            if ( ! empty( $download_url ) ) {
                            ?>
                            <a href="<?php echo esc_url( $download_url ); ?>" download class="button"><i class="fas fa-download"></i> Download</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        echo '</div>'; // Close the wrapper div

        // End output buffer and store output
        $output = ob_get_clean();
        
        // Restore original post data
        wp_reset_postdata();
    } else {
        // No assets found
        $output = '<p>No assets found.</p>';
    }

    // Return the generated HTML
    return $output;
}
add_shortcode( 'display_assets', 'stfq_display_assets_shortcode' );

// Enqueue scripts and styles for the front end
function stfq_enqueue_scripts_styles() {
    // Enqueue CSS stylesheet
    wp_enqueue_style( 'stfq-asset-manager-styles', plugins_url( 'stfq-asset-manager-styles.css', __FILE__ ), array(),);
}
add_action( 'wp_enqueue_scripts', 'stfq_enqueue_scripts_styles' );
