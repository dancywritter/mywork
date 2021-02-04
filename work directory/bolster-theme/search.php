<?php
	get_header();
	global  $cs_theme_option; 
 cs_enqueue_masonry_style_script();
 ?>
  <script type="text/javascript">
						jQuery(document).ready(function() {
							cs_masonary_callback('blog-gallery');
						});
						
					</script>
	<div class="main-section">
		<div class="right-content">
        <div class="cs-blog cs-default-view">
		<div class="blog-gallery">
				
		
			 <!-- Blog Post Start -->
			 <?php
			
				if ( have_posts() ) : 
				$count_posts = wp_count_posts();
				$published_posts = $count_posts->publish;
				?>
				<script type="text/javascript">
				jQuery(document).ready(function() {
					cs_load_more_search('25', '<?php echo $published_posts;?>', '<?php echo $_GET['s']; ?>', '<?php echo home_url() ?>','<?php echo get_template_directory_uri() ?>');
			   });
			 </script>
				<?php
					 while ( have_posts() ) : the_post();
					 
					 ?>	
						<article  class="post">
							<!-- News List Start -->
							<div class="article-wrapp">
						 
							<div class="desc">
								<h2 class="post-title">
									<a href="<?php the_permalink(); ?>" class="colrhover"><?php echo substr(get_the_title(),0,32); if(strlen(get_the_title()) > 32) echo "..."; ?></a>
								</h2>
								<p>
									<?php cs_get_the_excerpt(255,true);?>
								</p>
								<div class="bottom-post">
										<a class="img-icon-box" title="" data-toggle="tooltip" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" data-original-title="<?php echo get_the_author(); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('cs_author_bio_avatar_size', 50)); ?></a>
									<div class="text">
										<p class="panel">
											<time><?php echo get_the_date();?></time>
										</p>
										
									</div>
								</div>
							</div>
							
						</div>
						</article>
					<?php  
					endwhile;   
				else:
				?>
				<div style="float:left; width:1000px; margin:10px 0 0 20px;">
					<article>
						<h2 class="heading-color post-title"><?php _e( 'No results found.', 'Bolster'); ?></h2>
					</article>
					<div class="widget widget_search">
						<?php
						get_search_form();
						?>
					</div>
				</div>
				<?php 
				endif;
				
				?>
								
		</div>
		</div>
		</div>
		
	</div>	
			
<?php get_footer();?>
<!-- Columns End -->