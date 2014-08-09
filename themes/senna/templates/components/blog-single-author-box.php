<aside id="authorbox" itemscope itemtype="http://schema.org/Person">
	<div class="author-avatar"><?php
		if (function_exists('get_avatar_url')) {
			echo '<img src="'. get_avatar_url(get_the_author_meta('email'), '150') . '" itemprop="image"/>';
		} else if (function_exists('get_avatar')) {
			echo get_avatar(get_the_author_meta('email'), '150');
		}
	?></div>
	<div class="author-text">
		<h4 class="author-title">About <?php __('About', wpGrade_txtd); ?> <span itemprop="name"><?php the_author_posts_link(); ?></span></h4>
		<p class="author-bio" itemprop="description"><?php the_author_meta('description'); ?></p>
		<div class="author-footer">
			<ul class="team-member-social-links">
				<?php if ( get_the_author_meta('user_tw') ): ?>
				<li class="team-member-social-link"><a class="social-link" href="https://twitter.com/<?php echo get_the_author_meta('user_tw') ?>" target="_blank"><i class="icon-twitter"></i></a></li>
				<?php endif; ?>
				<?php if ( get_the_author_meta('user_fb') ): ?>
				<li class="team-member-social-link"><a class="social-link" href="https://www.facebook.com/<?php echo get_the_author_meta('user_fb') ?>" target="_blank"><i class="icon-facebook"></i></a></li>
				<?php endif; ?>
				<?php if ( get_the_author_meta('google_profile') ): ?>
				<li class="team-member-social-link"><a class="social-link" href="<?php echo get_the_author_meta('google_profile') ?>" target="_blank"><i class="icon-google-plus"></i></a></li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</aside>