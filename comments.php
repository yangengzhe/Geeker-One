<?php
defined('ABSPATH') or die('This file can not be loaded directly.');

global $comment_ids; $comment_ids = array();
foreach ( $comments as $comment ) {
	if (get_comment_type() == "comment") {
		$comment_ids[get_comment_id()] = ++$comment_i;
	}
} 

if ( !comments_open() ) return;

$my_email = get_bloginfo ( 'admin_email' );
$str = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_approved = '1' AND comment_type = '' AND comment_author_email";
$count_t = $post->comment_count;

date_default_timezone_set(PRC);
$closeTimer = (strtotime(date('Y-m-d G:i:s'))-strtotime(get_the_time('Y-m-d G:i:s')))/86400;
?>

<div id="respond" class="no_webshot">
  <?php if ( get_option('comment_registration') && !is_user_logged_in() ) { ?>
  <h3 class="queryinfo"> <?php printf('您必须 <a href="%s">登录</a> 才能发表评论！', wp_login_url( get_permalink() ) );?> </h3>
  <?php }elseif( get_option('close_comments_for_old_posts') && $closeTimer > get_option('close_comments_days_old') ) { ?>
  <h3 class="queryinfo"> 文章评论已关闭！ </h3>
  <?php }else{ ?>
  <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
    <div class="comt-title">
      <div class="comt-author pull-left">
        <?php 
				if ( is_user_logged_in() ) {
					printf($user_identity.'<span>发表我的评论</span>');
				}else{
					if( get_option('require_name_email') && !empty($comment_author_email) ){
						printf($comment_author.' <span>发表我的评论</span> &nbsp; <a class="switch-author" href="javascript:;" data-type="switch-author" style="font-size:12px;">换个身份</a>');
					}
				}
			?>
      </div>
      <a id="cancel-comment-reply-link" class="pull-right" href="javascript:;">取消评论</a> </div>
    <div class="comt">
      <div class="comt-box">
        <textarea placeholder="写点什么..." class="input-block-level comt-area" name="comment" id="comment" cols="100%" rows="3" tabindex="1" onkeydown="if(event.ctrlKey&amp;&amp;event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
        <div class="comt-ctrl">
          <button class="btn btn-primary pull-right" type="submit" name="submit" id="submit" tabindex="5"><i class="icon-ok-circle icon-white icon12"></i> 提交评论</button>
          <div class="comt-tips pull-right">
            <?php comment_id_fields(); do_action('comment_form', $post->ID); ?>
          </div>
          <span data-type="comment-insert-smilie" class="muted comt-smilie"><i class="icon-thumbs-up icon12"></i> 表情</span> <span class="muted comt-mailme">
          <?php deel_add_checkbox() ?>
          </span> </div>
      </div>
      <?php if ( !is_user_logged_in() ) { ?>
      <?php if( get_option('require_name_email') ){ ?>
      <div class="comt-comterinfo" id="comment-author-info" <?php if ( !empty($comment_author) ) echo 'style="display:none"'; ?>>
        <h4>Hi，您需要填写昵称和邮箱！</h4>
        <ul>
          <li class="form-inline">
            <label class="hide" for="author">昵称</label>
            <input class="ipt" type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" tabindex="2" placeholder="昵称">
            <span class="help-inline">昵称 (必填)</span></li>
          <li class="form-inline">
            <label class="hide" for="email">邮箱</label>
            <input class="ipt" type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" tabindex="3" placeholder="邮箱">
            <span class="help-inline">邮箱 (必填)</span></li>
          <li class="form-inline">
            <label class="hide" for="url">网址</label>
            <input class="ipt" type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" tabindex="4" placeholder="网址">
            <span class="help-inline">网址</span></li>
        </ul>
      </div>
      <?php } ?>
      <?php } ?>
    </div>
  </form>
  <?php } ?>
</div>
<?php  

if ( have_comments() ) { 
?>
<div id="postcomments">
  <h3 id="comments"> 网友最新评论<b><?php echo ' ('.$count_t.')'; ?></b> </h3>
  <ol class="commentlist">
    <?php wp_list_comments('type=comment&callback=deel_comment_list') ?>
  </ol>
  <div class="pagenav">
    <?php paginate_comments_links('prev_next=0');?>
  </div>
</div>
<?php 
} 
?>
