<div class="wrapper categories-dropdown">
	<div class="container">
		<div class="row">
			<?php
				// we get the categories so we know how many there are and adjust the number of tags displayed
				$args = array(
					'orderby' => 'name',
					'order' => 'ASC',
					'taxonomy' => 'portfolio_cat',
					);
				$categories = get_categories($args);
				$categories_num = count($categories);
				$tags_max = 8; //this is maximum the default
				$num_per_col = 3; //this is the default
				if ($categories_num > 8) {
					$num_per_col = 4;
					$tags_max = 11;
				} elseif ($categories_num > 11) {
					$num_per_col = 5;
					$tags_max = 14;
				} elseif ($categories_num > 14) {
					$num_per_col = 6;
					$tags_max = 17;
				}
			?>
			<?php global $wpGrade_Options;
			if ( $wpGrade_Options->get('portfolio_use_tags' ) ): ?>
			<div class="category-lists-container">
				<div class="row">
					<ul class="category-list span4">
						<li><span class="category-list-title"><?php echo __('Tags',wpGrade_txtd) ?></span></li>
						<li><a href="#" title="<?php echo __('View all projects',wpGrade_txtd) ?>" data-filter="*"><?php echo __('Show All',wpGrade_txtd) ?></a></li>
						<?php
							$list_idx = 2;
							$args = array(
								'orderby' => 'name',
								'order' => 'ASC',
								'number' => $tags_max,
								'post_type' => 'portfolio',
							);
							$tags = wpGrade_get_most_used_tags($args);
							foreach($tags as $tag):
								$tag_link = get_tag_link( $tag->term_id );
								echo '<li><a href="' . $tag_link . '" title="' . sprintf( __( "View all projects tagged with %s" ,wpGrade_txtd), ucfirst($tag->name) ) . '" ' . ' data-filter=".tag-'.  str_replace(' ','-',$tag->name).'">' . ucfirst($tag->name).'</a></li>';
								$list_idx++;
								if ($list_idx % $num_per_col == 0): ?>
					</ul>
					<ul class="category-list span4">
								<?php endif;
							endforeach;
						?>
					</ul>
				</div>
			</div>
			<?php endif; ?>
			<div class="category-lists-container" id="categories_list">
				<div class="row">
					<ul class="category-list span4">
						<li><span class="category-list-title"><?php echo __('Categories',wpGrade_txtd) ?></span></li>
						<li><a href="#" title="<?php echo __('View all projects',wpGrade_txtd) ?>" data-filter="*"><?php echo __('Show All',wpGrade_txtd) ?></a></li>
						<?php
						$list_idx = 2;
						foreach($categories as $category):
							if ($category->count > 0):
								echo '<li><a href="#" title="' . sprintf( __( "View all projects in %s" ,wpGrade_txtd), $category->name ) . '" ' . ' data-filter=".cat-'.str_replace(' ','-',$category->name).'">' . $category->name.'</a></li>';
								$list_idx++;
								if ($list_idx % $num_per_col == 0): ?>
									</ul>
									<ul class="category-list span4">
								<?php endif;
							endif;
						endforeach;
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>