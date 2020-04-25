<?php
/**
 * Template for the about tab on the settings page.
 *
 * @package Tasty_Pins
 */

?>

<style>
	main {
		max-width: 700px;
		margin-top: 1rem;
	}
	section::after {
		content: '';
		display: block;
		clear: both;
		margin-bottom: 2rem;
	}
	h2 {
		margin: 3rem auto 0;
	}
	p {
		font-size: 1rem;
	}
	.wp-core-ui .button {
		font-size: 1rem;
		padding: 5px 15px 6px;
		height: unset;
	}
	section img {
		max-width: 300px;
		display: block;
		margin: 1rem auto;
		box-shadow: 0 4px 8px 0 rgba(0,0,0,0.12),
			0 2px 4px 0 rgba(0,0,0,0.08);
	}
	@media screen and (min-width: 700px) {
		section img {
			margin: 0 0 1rem 1rem;
			margin-left: 1rem;
			float: right;
		}
		.lower {
			margin: 1rem 0 0 1rem;
		}
	}
</style>

<main>

	<h1><?php esc_html_e( 'Welcome to Tasty Pins! 🎉', 'tasty-pins' ); ?></h1>

	<section>

		<p><?php esc_html_e( 'Tasty Pins is a Pinterest optimization plugin for WordPress websites. By purchasing Tasty Pins, you\'re getting access to amazing Pinterest tools for your images, superior code quality, and a helpful support team ready to answer all your questions.', 'tasty-pins' ); ?></p>

		<h2><?php esc_html_e( 'Getting Started', 'tasty-pins' ); ?></h2>

		<p><?php esc_html_e( 'Tasty Pins doesn\'t require any sort of configuration - it just works! The magic happens in your posts, where you can add extra information to your images to help your content stand out on Pinterest.', 'tasty-pins' ); ?></p>

	</section>

	<section>

		<h2><?php esc_html_e( 'Add Pinterest Descriptions', 'tasty-pins' ); ?></h2>

		<img src="<?php echo esc_url( plugins_url( 'assets/images/tasty-pins-pinterest-description.png', __DIR__ ) ); ?>" data-pin-nopin="true" alt="Screenshot of the Tasty Pins fields in the block editor, including Pinterest Text, Disable Pinning, and Repin ID" />

		<p><?php esc_html_e( 'Tasty Pins enables you to set a Pinterest Description for your images separate from the alt text. This means that you can use your alt text for what it\'s intended - describing the image for screen readers and search results - while still providing an optimized description for Pinterest.', 'tasty-pins' ); ?></p>

		<p>
		<?php
		printf(
			// translators: "adding Pinterest text to your images" and "writing great Pinterest descriptions".
			esc_html__( 'Learn more about %1$s and %2$s.', 'tasty-pins' ),
			sprintf(
				'<a href="https://support.wptasty.com/tasty-pins/how-do-i-add-a-pinterest-text-to-my-image" target="_blank">%s</a>',
				esc_html__( 'adding Pinterest Text to your images', 'tasty-pins' )
			),
			sprintf(
				'<a href="https://www.wptasty.com/blog/how-to-write-great-pinterest-image-descriptions" target="_blank">%s</a>',
				esc_html__( 'writing great Pinterest descriptions', 'tasty-pins' )
			)
		);
		?>
		</p>

		<h2><?php esc_html_e( 'Grow Your Pin Repin Count', 'tasty-pins' ); ?></h2>

		<p><?php esc_html_e( 'The number of Repins (or saves) an image has on Pinterest is a type of "ranking signal" for Pinterest searches. Pins with higher numbers of repins show up in search more frequently.', 'tasty-pins' ); ?></p>

		<p><?php esc_html_e( 'With Tasty Pins, you can add a Repin ID to your images to help boost the number of repins for images already on Pinterest.', 'tasty-pins' ); ?></p>

		<p>
		<?php
		printf(
			// translators: "Pinterest Repins".
			esc_html__( 'Learn more about %1$s and how to make them work for you.', 'tasty-pins' ),
			sprintf(
				'<a href="https://www.wptasty.com/blog/pinterest-repins" target="_blank">%s</a>',
				esc_html__( 'Pinterest Repins', 'tasty-pins' )
			)
		);
		?>
		</p>

	</section>

	<section>

		<h2><?php esc_html_e( 'Add Hidden Images', 'tasty-pins' ); ?></h2>

		<img src="<?php echo esc_url( plugins_url( 'assets/images/tasty-pins-hidden-image.png', __DIR__ ) ); ?>" data-pin-nopin="true" alt="Screenshot of the Tasty Pins meta area where you can add hidden images and force-pin the first hidden image" />

		<p><?php esc_html_e( 'Some images are great for Pinterest, but they don\'t look that great on your site. Add these as Hidden Images to your page and they\'ll appear as an option when readers go to save your content to Pinterest.', 'tasty-pins' ); ?></p>

		<p><?php esc_html_e( 'Better yet, check the "force-pin" box and any image in the content will automatically use this hidden image when it\'s saved to Pinterest.', 'tasty-pins' ); ?></p>

		<p>
		<?php
		printf(
			// translators: "adding hidden images" and "force-pinning hidden images".
			esc_html__( 'Learn more about %1$s and %2$s.', 'tasty-pins' ),
			sprintf(
				'<a href="https://support.wptasty.com/tasty-pins/how-do-i-add-a-hidden-pinterest-image" target="_blank">%s</a>',
				esc_html__( 'adding hidden images', 'tasty-pins' )
			),
			sprintf(
				'<a href="https://support.wptasty.com/tasty-pins/how-do-i-force-pinning-of-a-hidden-image" target="_blank">%s</a>',
				esc_html__( 'force-pinning hidden images', 'tasty-pins' )
			)
		);
		?>
		</p>

	</section>

	<section>

		<h2><?php esc_html_e( 'Visit Our Documentation', 'tasty-pins' ); ?></h2>

		<p><?php esc_html_e( 'There\'s even more to Tasty Pins! To learn more and get answers to your questions, visit our plugin documentation. If your questions aren\'t answered there, send us a quick chat and we\'ll be happy to help.', 'tasty-pins' ); ?></p>

		<p><a class="button" href="https://support.wptasty.com/tasty-pins" target="_blank"><?php esc_html_e( 'Visit Documentation', 'tasty-pins' ); ?></a>

	</section>

</main>
