<?php
/**
 * Page Template
 *
 * Template for simple page.
 *
 * @since 	3.0.0
 * @package RH/modern
 */
include_once WP_PLUGIN_DIR .'/inspiry-memberships/inspiry-memberships.php';
get_header();

$header_variation = get_option( 'inspiry_pages_header_variation' );

if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/header' );
} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/image' );
}

if ( inspiry_show_header_search_form() ) {
	get_template_part( 'assets/modern/partials/properties/search/advance' );
}

?>

<section class="rh_section rh_section--flex rh_wrap--padding rh_wrap--topPadding">

	<div class="rh_page rh_page__listing_page rh_page__main">


		<div class="rh_blog rh_blog__listing rh_blog__single">

							<!-- /.title -->
							<?php
							$ims_functions = IMS_Functions();
							$is_memberships_enable = $ims_functions::is_memberships();
							// Get current user data.
							$current_user = wp_get_current_user();

							// Get current membership of user.
							$current_membership = $ims_functions::ims_get_membership_by_user( $current_user );
							if ( is_array( $current_membership ) && ! empty( $current_membership ) ) {
								?>
								<div class="details">
									<p class="membership">Você está atualmente com o <?php echo esc_html( $current_membership[ 'title' ] ); ?> ativo.</p>
									<!-- /.cancel -->
								</div>
								<!-- /.details -->
								<?php
							} else {
								?>
								<p class="message">Você ainda não tem um plano de anúncio contratado.<br>Escolha uma das opções abaixo e efetue o pagamento.</p><?php
							}
							?>

			<?php

				// Setup your custom query
			$args = array(
				'post_type' => 'product',
				'meta_query'  => array(
					array(
						'key'     => '_membership',
						'value'   => 0,
						'compare' => '!=',
						'type'    => 'numeric'
					)
				)
			);
			$loop = new WP_Query( $args );

			while ( $loop->have_posts() ) : $loop->the_post(); ?>
					<?php
					$membership = get_post_meta($loop->post->ID, '_membership', true);
					$membership 	= new IMS_Get_Membership($membership);
					$properties = $membership->get_properties();
					$featured_properties = $membership->get_featured_properties();
					$duration = $membership->get_duration();
					$duration_unit = $membership->get_duration_unit();
					$product = wc_get_product( $loop->post->ID );
					$product_value = $product->get_price_html();
					if ($properties > 1) {
						$plural = 'imóveis';
					} else {
						$plural = 'imóvel';
					}
					if ($featured_properties > 1) {
						$fplural = 'imóveis';
					} else {
						$fplural = 'imóvel';
					}
					//var_dump($product_value);
					if ($duration_unit == 'days') {
						$duration_unit = 'dias';
					}
					if ($duration_unit == 'months') {
						$duration_unit = 'meses';
					}
					if ($duration_unit == 'weeks') {
						$duration_unit = 'semanas';
					}
					if ($duration_unit == 'years') {
						$duration_unit = 'anos';
					}
					//echo $properties .' - '.  $featured_properties .' - '. $duration .' - '. $duration_unit;
					?>

					<div id="box-plans">
						<div class="box-plans-inner">
							<h2 class="box-plans-title"><?php the_title(); ?></h2>
							<span class="box-plans-value"><sup>R$</sup><?php echo $product_value ?></span>
							<ul class="box-plans-itens">
								<li>Anuncie até <?php echo $properties . ' ' . $plural ?></li>
								<li>Escolha até <?php echo $featured_properties . ' ' . $fplural?>  como destaque</li>
								<li>Durante <?php echo $duration . ' ' . $duration_unit?></li>
							</ul>
							<?php echo do_shortcode('[add_to_cart id="' . $loop->post->ID . '"]'); ?>
						</div>
					</div>

					

			<?php endwhile; wp_reset_query(); // Remember to reset ?>

		</div>
		<!-- /.rh_blog rh_blog__listing -->


	</div>
	<!-- /.rh_page rh_page__main -->

	<div class="rh_page rh_page__sidebar">
		<?php get_sidebar( 'pages' ); ?>
	</div>
	<!-- /.rh_page rh_page__sidebar -->

</section>
<!-- /.rh_section rh_wrap rh_wrap--padding -->

<?php
get_footer();
