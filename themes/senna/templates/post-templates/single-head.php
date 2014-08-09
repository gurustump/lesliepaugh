<?php	
   global $wpGrade_Options;
   ?>
<header class="entry-header">
	<?php if (is_single()) :?>
	<hr />
	<h1 class="entry-title single-title" itemprop="name"><?php echo get_the_title(); ?></h1>
	<?php else : ?>
	<hr>
	<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', wpGrade_txtd ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	<?php endif; ?>
	<div class="posted-on"><?php wpgrade_posted_on(); ?> / 
		<div class="categories"><?php
			$categories = get_the_category();
			$separator = ' / ';
			$output = '';
			if($categories){
				foreach($categories as $category) {
					$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", wpGrade_txtd ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
				}
			echo trim($output, $separator);
			}
		?>
		</div>
	</div>
</header><!-- .entry-header -->
							
<?php if ( $wpGrade_Options->get('blog_show_featured_image') && !is_single() ) { 
	echo '<a href="'.get_permalink().'" title="'.esc_attr( sprintf( __( 'Read more about %s', wpGrade_txtd ), the_title_attribute( 'echo=0' ) ) ).'" rel="bookmark">'; wpgrade_get_thumbnail( 'blog-big', 'entry-featured-image' ); echo '</a>';
	} ?>