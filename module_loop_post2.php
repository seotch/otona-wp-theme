<?php
$postType = get_post_type();
if ($postType == 'post') {
	$taxonomySlug = 'category';
} else {
	$taxonomies = get_the_taxonomies();
	if ($taxonomies) {
		foreach ( $taxonomies as $taxonomySlug => $taxonomy ) {}
	} else {
		$taxonomySlug = '';
	}
}
$taxo_catelist = get_the_term_list( $post->ID, $taxonomySlug, ' ','','');
?>
<!-- [ .infoListBox ] -->
<div id="post-<?php the_ID(); ?>" class="infoListBox ttBox">
	<?php if ( has_post_thumbnail()) { ?>
		<div class="thumbImage ttBoxThumb">
		<div class="thumbImageInner">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
		</div>
		</div><!-- [ /.thumbImage ] -->
	<?php } ?>
	<div class="entryTxtBox<?php if ( has_post_thumbnail()) echo ' haveThumbnail'; ?>">
	<h4 class="entryTitle">
	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	<?php if ( is_user_logged_in() == TRUE ) : edit_post_link(__('Edit', 'biz-vektor'), '<span class="edit-link edit-item">[ ', ' ]</span>');endif ?>
	</h4>
	<p class="entryMeta">
	<span class="infoDate"><?php echo esc_html( get_the_date() ); ?></span><span class="infoCate"><?php echo $taxo_catelist; ?></span>
	</p>
	<p><?php the_excerpt(); ?></p>
	<div class="moreLink"><a href="<?php the_permalink(); ?>"><?php _e('Read more', 'biz-vektor'); ?></a></div>
	</div><!-- [ /.entryTxtBox ] -->


</div><!-- [ /.infoListBox ] -->
