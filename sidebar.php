<aside id="sidebar">
  <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/scroll_top_control.js"></script>
  <div class="aside_search">
    <form method="get" class="dropdown search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" >
      <input class="search-input" name="s" maxlength="15" lang="zh-CN" type="search" placeholder="Search..." x-webkit-speech >
      <input class="search_submit_btn" type="submit" value="搜索">
    </form>
  </div>
  <div class="aside_hot">
    <h3 class="aside_hot_tit">热门文章</h3>
    <ul class="aside_hot_box">
<?php 
global $post; 
$postid = $post->ID; 
$args = array( ‘orderby’ => ‘rand’, ‘post__not_in’ => array($post->ID), ‘showposts’ => 8); 
$query_posts = new WP_Query(); 
$query_posts->query($args); 
?> 



<?php while ($query_posts->have_posts()) : $query_posts->the_post(); ?> 


<li><i class="aside_post_list_num"></i><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"> <?php the_title(); ?></a></li>

<?php endwhile; ?> 

    </ul>

  </div>
  <div class="aside_tag" >
    <h3 class="aside_tag_tit">相关标签</h3>
    <?php $html = '<ul class="aside_tag_content">';

				foreach (get_tags( array('number' => 45, 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => false) ) as $tag){

				        $tag_link = get_tag_link($tag->term_id);

				        $html .= "<li><a href='{$tag_link}' title='查看有关 {$tag->name} 的文章' class='{$tag->slug}'>";

				        $html .= "{$tag->name} ({$tag->count})</a></li>";

				}

			$html .= '</ul>';

			echo $html; ?>
  </div>
  <div class="aside_friendLink" >
    <h3 class="aside_friendLink_tit">友情链接</h3>
    <?php wp_nav_menu( array( 'theme_location' => 'friendLink_menu', 'container' => false, 'items_wrap' => '<ul id="friendLink_menu">%3$s</ul>'));?>
  </div>
  <div id="aside_ad_box">

<?php if (current_user_can('edit_posts')) { ?>
<div class="aside_feed_btn" style="margin:5px 0 0 0;display: flex;">
	<a href="wp-admin/" target="_blank" style="width:50%; margin-right:3px;">管理</a>
	<a href="wp-login.php?action=logout" target="_blank" style="width:50%; margin-left:3px;">登出</a>
</div>
<?php }else{ ?>
<div class="aside_feed_btn" style="margin:5px 0 0 0;display: flex;">
	<a href="wp-login.php" target="_blank" style="width:50%; margin-right:3px;">登陆</a>
	<a href="wp-login.php?action=register" target="_blank" style="width:50%; margin-left:3px;">注册</a>
</div>
<?php } ?>

<!--
    <div class="aside_feed_btn" style="margin:5px 0 0 0;"><a href="#" target="_blank" >与我联系</a></div>
-->   
  </div>
</aside>
