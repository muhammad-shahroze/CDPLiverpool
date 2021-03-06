<?php if ( $query_results->max_num_pages > 1 ) { ?>
	<div class="qodef-pl-loading">
		<div class="qodef-brunn-spinner-holder">
			<div class="qodef-brunn-spinner">
				<div></div>
			</div>
		</div>
	</div>
	<?php
	$pages = $query_results->max_num_pages;
	$paged = $query_results->query['paged'];
	
	if ( $pages > 1 ) { ?>
		<div class="qodef-pl-standard-pagination">
			<ul>
				<li class="qodef-pag-prev">
					<a href="#" data-paged="1"><span class="arrow_carrot-left"></span></a>
				</li>
				<?php for ( $i = 1; $i <= $pages; $i ++ ) { ?>
					<?php
					$link_classes = '';
					if ( $paged == $i ) {
						$link_classes = 'qodef-pag-active';
					}
					?>
					<li class="qodef-pag-number <?php echo esc_attr( $link_classes ); ?>">
						<a href="#" data-paged="<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></a>
					</li>
				<?php } ?>
				<li class="qodef-pag-next">
					<a href="#" data-paged="2"><span class="arrow_carrot-right"></span></a>
				</li>
			</ul>
		</div>
	<?php }
} ?>
