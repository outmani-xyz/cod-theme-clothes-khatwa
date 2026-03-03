<?php

/**
 * The main template file
 *
 * @package khutwa
 */

get_header(); ?>

<main id="primary" class="site-main mt-5 container container-narrow">

	<?php
	if (have_posts()) :
		while (have_posts()) :
			the_post();
	?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('mb-5'); ?>>
				<header class="entry-header mb-4">
					<?php the_title('<h1 class="entry-title text-start">', '</h1>'); ?>
				</header>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
	<?php
		endwhile;
	else :
		echo '<p class="text-start">' . __('No content found.', 'khutwa') . '</p>';
	endif;
	?>

</main>

<?php get_footer(); ?>