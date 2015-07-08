<a class="twitter" href="https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?> - <?php echo get_permalink(); ?> by @bulledev"><span class="icon icon-twitter"></span> Tweet</a>

<a class="facebook" href="#" onclick="
    window.open(
      'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href),
      'facebook-share-dialog',
      'width=626,height=436');
    return false;"><span class="icon icon-facebook"> <?php _e("Share","atom"); ?></span>
</a>