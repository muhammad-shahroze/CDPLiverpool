<li class="qodef-blog-slider-item">
    <div class="qodef-blog-slider-item-inner">
        <div class="qodef-item-image">
            <a itemprop="url" href="<?php echo get_permalink(); ?>">
                <?php echo get_the_post_thumbnail(get_the_ID(), $image_size); ?>
            </a>
        </div>
        <div class="qodef-item-text-wrapper">
            <div class="qodef-item-text-holder">
                <div class="qodef-item-text-holder-inner">
	                <?php if($post_info_date == 'yes' || $post_info_category == 'yes' || $post_info_author == 'yes' || $post_info_comments == 'yes'){ ?>
		                <div class="qodef-item-info-section">
			                <?php
			                if ($post_info_date == 'yes') {
				                brunn_select_get_module_template_part('templates/parts/post-info/date', 'blog', '', $params);
			                }
			                if ($post_info_category == 'yes') {
				                brunn_select_get_module_template_part('templates/parts/post-info/category', 'blog', '', $params);
			                }
			                if ($post_info_author == 'yes') {
				                brunn_select_get_module_template_part('templates/parts/post-info/author', 'blog', '', $params);
			                }
			                if ($post_info_comments == 'yes') {
				                brunn_select_get_module_template_part('templates/parts/post-info/comments', 'blog', '', $params);
			                }
			                ?>
		                </div>
	                <?php } ?>
	
	                <?php brunn_select_get_module_template_part('templates/parts/title', 'blog', '', $params); ?>

                    <?php brunn_select_get_module_template_part('templates/parts/post-info/read-more', 'blog', '', $params); ?>
                </div>
            </div>
        </div>
    </div>
</li>