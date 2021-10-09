<div class="ob_instructor clearfix">
	<div class="images">
		<div class="avatar"><?php echo get_avatar( get_the_author_meta( 'ID',$user_id), 150 ); ?></div>
		<div class="link_buttons">
			<?php if ($homepage = get_the_author_meta('user_url',$user_id)) { ?>
				<a target="_blank" href="<?php echo $homepage; ?>" class="homepage"><img src="<?php echo get_stylesheet_directory_uri(); ?>/icon_homepage.png"></a>
			<?php } ?>
			<?php if ($twitter = get_the_author_meta('twitter',$user_id)) { ?>
			<a target="_blank" href="https://twitter.com/<?php echo $twitter; ?>"  class="twitter"><img src="<?php echo get_stylesheet_directory_uri(); ?>/icon_twitter.png"></a>
			<?php } ?>
			<?php  if ($facebook = get_the_author_meta('facebook',$user_id)) { ?>
			<a target="_blank" href="https://www.facebook.com/<?php echo $facebook; ?>"  class="facebook"><img src="<?php echo get_stylesheet_directory_uri(); ?>/icon_facebook.png"></a>
			<?php } ?>
			<?php if ($pixiv = get_the_author_meta('Pixiv',$user_id)) { ?>
			<a target="_blank" href="http://www.pixiv.net/member.php?id=<?php echo $pixiv; ?>"  class="pixiv"><img src="<?php echo get_stylesheet_directory_uri(); ?>/icon_pixiv.png"></a>
			<?php } ?>
		</div>
	</div>

	<div class="data">
		<div class="name"><?php the_author_meta('display_name',$user_id); ?></div><div class="name_kana"><?php the_author_meta('name_kana',$user_id); ?></div>
		<div class="title"><?php the_author_meta('title',$user_id); ?></div>
		<div class="description"><?php the_author_meta('description',$user_id); ?></div>
	</div>
</div>
