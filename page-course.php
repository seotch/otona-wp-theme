<?php
/*
 * Template Name: 講座
 */
get_header(); ?>
<?php
    // 講座名から講座情報を取得.
    global $wpdb;
    $sql = $wpdb->prepare('SELECT * FROM wp_otona_courses WHERE name = %s', get_the_title());
    $the_Course = $wpdb->get_row($sql, ARRAY_A);
?>

<!-- [ #container ] -->
<div id="container" class="innerBox">
<!-- [ #content ] -->
<div id="content" class="course content">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div id="post-V" class="entry-content">
    <section class="lead">
    <div class="post_title_image"><?php the_post_thumbnail('full'); ?></div>
    <div class="right">
    <?php if ($the_Course['day_time']) { ?>
        <a href="#class_lecture"><img src="http://otonanobijutsu.com/site/wp-content/uploads/2018/04/0abbd033ac33a149f47ec979daec9455.png" title="教室受講あり" style="width:50px; margin-bottom: 20px;"/></a>
    <?php } ?>
      <?php if ($the_Course['video_tuition']) { ?>
        <a href="#video_lecture"><img src="http://otonanobijutsu.com/site/wp-content/uploads/2018/04/188513e56ade042f0a4c904f2ba97e32.png" title="ビデオ受講あり" style="width:50px; margin-bottom: 20px;"/></a>
    <?php } ?>    

    </div>
    <?php the_field('lead_text'); ?>
    <!-- お申し込みボタン -->
    <div class="ob_entry">
    <?php if ($the_Course['type'] == '基礎講座') { ?>
        <a class="btn btnL" href="#special">講座を体験する</a>
        <a class="btn btnL" href="<?php bloginfo('url'); ?>/entry/entry-course#course-<?php the_ID(); ?>">講座に申し込む</a>
    <?php } elseif ($the_Course['type'] == '添削塾') {?>
        <a class="btn btnL" href="<?php bloginfo('url'); ?>/entry/entry-course#course-<?php the_ID(); ?>">添削塾に申し込む</a>
    <?php } elseif ($the_Course['type'] == '通信講座') {?>
        <a class="btn btnL" href="<?php bloginfo('url'); ?>/entry/entry-correspond#course-<?php the_ID(); ?>">通信講座に申し込む</a>
    <?php } elseif ($the_Course['type'] == 'スポット講座') {?>
        <a class="btn btnL" href="<?php bloginfo('url'); ?>/spot#course-<?php the_ID(); ?>">講座に申し込む</a>
    <?php } ?>
    </div>
    <!-- お申し込みボタン -->
    </section>



    <section class="clearfix">
    <h2>概要</h2>
    <?php
    $wysiwyg = get_field('description', false, false);
    echo apply_filters('the_content', $wysiwyg);
    ?>
    </section>

    <section>
    <h2>担当講師</h2>
    <?php echo do_shortcode('[ob_instructors]');?>
    </section>

    <section>
    <h2>募集要項</h2>
    <?php if ($the_Course['type'] != '通信講座') { ?>
      <h3 id="class_lecture">教室受講 <a href="http://otonanobijutsu.com/faq/%E6%95%99%E5%AE%A4%E5%8F%97%E8%AC%9B%E3%81%A8%E3%83%93%E3%83%87%E3%82%AA%E5%8F%97%E8%AC%9B%E3%81%AE%E9%81%95%E3%81%84%E3%81%AF%EF%BC%9F">(教室受講とは？)</a></h3>
    <?php } ?>
    <table>
        <tbody>
            <tr>
                <th>回数・期間</th>
                <td><?php echo $the_Course['times']; ?></td>
            </tr>
            <tr>
                <th>募集時期</th>
                <td><?php echo $the_Course['cycle'];?></td>
            </tr>
            <tr>
                <th>開講日</th>
                <td><?php echo $the_Course['start_date'];?></td>
            </tr>
    <?php if ($the_Course['day_time']) { ?>
            <tr>
                <th>曜日・時間</th>
                <td><?php echo $the_Course['day_time'];?></td>
            </tr>
    <?php } ?>
        <tr>
            <th>入部費</th>
            <td><?php echo $the_Course['entry_fee'];?></td>
        </tr>
        <tr>
            <th>授業料</th>
            <td><?php echo $the_Course['tuition'];?></td>
        </tr>
        </tbody>
    </table>
    <?php if ($the_Course['video_tuition']) { ?>
    <h3 id="video_lecture">ビデオ受講 <a href="http://otonanobijutsu.com/faq/%E6%95%99%E5%AE%A4%E5%8F%97%E8%AC%9B%E3%81%A8%E3%83%93%E3%83%87%E3%82%AA%E5%8F%97%E8%AC%9B%E3%81%AE%E9%81%95%E3%81%84%E3%81%AF%EF%BC%9F">(ビデオ受講とは？)</a>
   </h3>
   
    <table>
        <tbody>
            <tr>
                <th>回数・期間</th>
                <td><?php echo $the_Course['times']; ?></td>
            </tr>
            <tr>
                <th>募集時期</th>
                <td>いつでも</td>
            </tr>
            <tr>
                <th>開講日</th>
                <td>いつでも</td>
            </tr>
       <tr>
            <th>入部費</th>
            <td><?php echo $the_Course['entry_fee'];?></td>
        </tr>
        <tr>
            <th>授業料</th>
            <td><?php echo $the_Course['video_tuition'];?></td>
        </tr>
        </tbody>
    </table>
    <?php } ?>
    
    <?php if ($the_Course['type'] == '基礎講座') { ?>
    <div class="ob_entry">
        <a class="btn btnL" href="<?php bloginfo('url'); ?>/entry/entry-course#course-<?php the_ID(); ?>">講座に申し込む</a>
    </div>
    <?php } ?>
   </section>


    <?php if (get_field('syllabus')) { ?>
    <section>
    <h2>学習内容</h2>
    <?php the_field('syllabus'); ?>
    </section>
    <?php } ?>

    <?php if (get_field('other')) { ?>
    <section>
    <h2>備考</h2>
    <?php the_field('other'); ?>
    </section>
    <?php } ?>


    <?php if ($the_Course['type'] == '基礎講座') { ?>
    <section>
        <a name="special">
            <h2>特別講座</h2>
        </a>
    <p>
        定期的に開催している特別講座では、基礎講座第１回目の内容を、お試し価格の<strong>1000円</strong>で受講していただけます。特別講座の雰囲気は、動画でご覧ください。
    <?php the_field('special'); ?>
    <?php } ?>
    </section>

    <!-- お申し込みボタン -->
    <section>
    <div class="ob_entry">
    <?php if ($the_Course['type'] == '基礎講座') { ?>
        <p style="text-align:center;">
            興味を持ったら、開催日時をチェック！</br>
            １回につき定員８名様までの募集です。
        </p>
        <a class="btn btnL" href="<?php bloginfo('url'); ?>/special#course-<?php the_ID(); ?>">特別講座の開催日時を見る</a>
    <?php } elseif ($the_Course['type'] == '添削塾') {?>
        <a class="btn btnL" href="<?php bloginfo('url'); ?>/entry/entry-course#course-<?php the_ID(); ?>">添削塾に申し込む</a>
    <?php } elseif ($the_Course['type'] == '通信講座') {?>
        <a class="btn btnL" href="<?php bloginfo('url'); ?>/entry/entry-correspond#course-<?php the_ID(); ?>">通信講座に申し込む</a>
    <?php } elseif ($the_Course['type'] == 'スポット講座') {?>
            <a class="btn btnL" href="<?php bloginfo('url'); ?>/spot#course-<?php the_ID(); ?>">講座に申し込む</a>
    <?php } ?>
    </div>
    <!-- お申し込みボタン -->
    </section>

    <?php wp_link_pages(array('before' => '<div class="page-link">' . 'Pages:', 'after' => '</div>')); ?>
</div><!-- .entry-content -->

<?php edit_post_link(__('Edit', 'biz-vektor'), '<div class="adminEdit"><span class="linkBtn linkBtnS linkBtnAdmin">', '</span></div>'); ?>

<?php endwhile;?>
<?php endif; ?>

<?php // Child page list ?>
<?php
if ($post->ancestors) {
    foreach ($post->ancestors as $post_anc_id) {
        $post_id = $post_anc_id;
    }
} else {
    $post_id = $post->ID;
}
if ($post_id) {
    $children = wp_list_pages('title_li=&child_of=' . $post_id . '&echo=0');
    if ($children) { ?>
         <div class="childPageBox">
         <h4><a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a></h4>
         <ul>
        <?php echo $children; ?>
         </ul>
         </div>
    <?php   } ?>
<?php } ?>
<?php // /Child page list ?>

<?php get_template_part('module_mainfoot'); ?>

<?php do_action('biz_vektor_snsBtns'); ?>
<?php do_action('biz_vektor_fbComments'); ?>
<?php do_action('biz_vektor_fbLikeBoxDisplay'); ?>
</div>
<!-- [ /#content ] -->

<!-- [ #sideTower ] -->
<div id="sideTower" class="sideTower">
    <?php get_sidebar('page'); ?>
</div>
<!-- [ /#sideTower ] -->
<?php biz_vektor_sideTower_after();?>
</div>
<!-- [ /#container ] -->

<?php get_footer(); ?>
