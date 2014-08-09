<?php
/**
 * The template for displaying search forms in wpGrade
 *
 * @package wpGrade
 * @since wpGrade 1.0
 */
?>
	<div class="form">
		<form method="get" id="searchform" class="form-search" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
			
			<input type="text" class="field input-medium search-query" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php esc_attr_e( 'Search &hellip;', wpGrade_txtd ); ?>" />
			<button class="btn submit" name="submit" id="searchsubmit"><?php //esc_attr_e( 'Search', wpGrade_txtd ); ?> <i icon-search></i> Search</button>
		</form>
	</div>