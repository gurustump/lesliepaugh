<div class="wrapper categories-dropdown">
	<div class="container">
		<div class="row">
			<?php
				// we get the categories so we know how many there are and adjust the number of tags displayed
				$args = array(
					'orderby' => 'name',
					'order' => 'ASC',
					);
				$categories = get_categories($args);
				$categories_num = count($categories);
				$tags_max = 8; //this is maximum the default
				$num_per_col = 3; //this is the default
				if ($categories_num > 8) {
					$num_per_col = 4;
					$tags_max = 11;
				}
				if ($categories_num > 11) {
					$num_per_col = 5;
					$tags_max = 14;
				}
				if ($categories_num > 14) {
					$num_per_col = 6;
					$tags_max = 17;
				}
			?>
			<div class="category-lists-container">
				<div class="row">
					<ul class="category-list span4">
						<li><span class="category-list-title"><?php echo __('Tags',wpGrade_txtd) ?></span></li>
						<?php
							$list_idx = 1;
							$args = array(
								'orderby' => 'name',
								'order' => 'ASC',
								'number' => $tags_max
							);
							$tags = wpGrade_get_most_used_tags($args);
							foreach($tags as $tag):
								$tag_link = get_tag_link( $tag->term_id );
								echo '<li><a href="' . $tag_link . '" title="' . sprintf( __( "View all posts tagged with %s" ,wpGrade_txtd), $tag->name ) . '" ' . '>' . $tag->name.'</a></li>';
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
			<div class="category-lists-container">
				<div class="row">
					<ul class="category-list span4">
						<li><span class="category-list-title"><?php echo __('Categories',wpGrade_txtd) ?></span></li>
						<?php
							$list_idx = 1;
							foreach($categories as $category):
								echo '<li><a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ,wpGrade_txtd), $category->name ) . '" ' . '>' . $category->name.'</a></li>';
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
		</div>
	</div>
</div>