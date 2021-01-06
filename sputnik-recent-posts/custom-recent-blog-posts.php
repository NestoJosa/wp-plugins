<?php

/*

  Plugin Name: Ernies Recent Blog Posts Plugin
  Description: This plugin adds a custom widget that shows the three most recent blog posts
  Version: 1.0
  Source: https://www.wpexplorer.com/create-widget-plugin-wordpress/

*/

// The widget class
class Ernies_Recent_Blog_Posts_Widget extends WP_Widget {

	// Main constructor
	public function __construct() {
		parent::__construct(
			'ernies_recent_blog_posts_widget',
			__( 'Ernies Recent Blog Posts Widget', 'sputnik' )
		);
	}

	// Display the widget
	public function widget( $args, $instance ) {

		extract( $args );

    // WordPress core before_widget hook (always include)
		echo $before_widget;

    // the query
    $wpb_recent_query = new WP_Query(
      array(
        'post_type' => 'post', 
        'post_status' => 'publish', 
        'posts_per_page' => 3
      )
    ); 
    
    if ( $wpb_recent_query -> have_posts() ) : ?>
    
      <div class="cards-grid-wrapper">
        <div class="cards-grid cards-grid--three-cols">
          
          <?php 
          
          // the loop  
          while ( $wpb_recent_query -> have_posts() ) : $wpb_recent_query -> the_post(); ?>

        
          <div class="cards-grid__item">
            <!-- the blog post card -->
            <div class="blog-post-card">
              <img 
                class="blog-post-card__image"
                src="<?php the_post_thumbnail_url(); ?>" 
                alt="<?php the_title(); ?>"
              />
              <h4 class="blog-post-card__heading"><?php the_title(); ?></h4>
              <p class="blog-post-card__excerpt"><?php echo get_the_excerpt() ?></p>
              <a 
                class="blog-post-card__link"
                href="<?php the_permalink() ?>"
                >
                  <span class="blog-post-card__link-text">Læs mere</span>
                  <span><i class="icon-right-arrow"></i></span>
              </a>
            </div><!-- /blog-post-card -->
          </div><!-- /cards-grid__item -->

          <?php endwhile; // end of the loop ?>
      
        </div> <!--/cards-grid-->
      </div><!--/cards-grid-wrapper -->

      <?php wp_reset_postdata(); ?>
    
    <?php else : ?>
        <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
    <?php endif; ?>  

    <?php

		// WordPress core after_widget hook (always include )
		echo $after_widget;
	}
};

// Register the widget
function register_recent_posts_widget() {
	register_widget( 'Ernies_Recent_Blog_Posts_Widget' );
}
add_action( 'widgets_init', 'register_recent_posts_widget' );

?>