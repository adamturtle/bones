<?php get_header(); ?>

			<div id="content" class="clearfix row">

				<div id="main" class="col-md-8 clearfix" role="main">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

						<header>

							<h1 class="single-title" itemprop="headline"><?php the_title(); ?></h1>

							<p class="meta">
								<data itemprop="datePublished" value="<?php echo the_time('Y-m-j'); ?>">
									<?php the_time('F jS, Y'); ?>
								</data>
							</p>

						</header> <!-- end article header -->

						<section class="post_content clearfix" itemprop="articleBody">

							<?php the_content(); ?>

						</section> <!-- end article section -->

						<footer>
						</footer> <!-- end article footer -->

					</article> <!-- end article -->

					<?php //comments_template(); ?>

					<?php endwhile; ?>

					<?php else : ?>

					<article id="post-not-found">
					    <header>
					    	<h1>Not Found</h1>
					    </header>
					    <section class="post_content">
					    	<p>Sorry, but the requested resource was not found on this site.</p>
					    </section>
					    <footer>
					    </footer>
					</article>

					<?php endif; ?>

				</div> <!-- end #main -->

				<?php //get_sidebar(); // sidebar 1 ?>

			</div> <!-- end #content -->

<?php get_footer(); ?>