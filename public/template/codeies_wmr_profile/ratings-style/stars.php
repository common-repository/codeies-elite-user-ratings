<div class="starrating-main">
<div class="starrating-div">
<span><?php echo esc_html($review['rating_label']); ?></span>
<span data-name="review_<?php echo esc_html($review['rating_name']); ?>" data-value="<?php echo(isset($review['value']) ?(esc_html($review['value'])):('1')); ?>"  class="cwmrstars" id="range_<?php echo rand(999,9999); ?>" data-disabled="<?php echo(isset($review['value']) ?('true'):('false')); ?>"></span>
</div>
</div>