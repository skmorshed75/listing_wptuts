<?php
namespace Jet_Reviews\Reviews;

use Jet_Reviews\Base_Render as Base_Render;
use Jet_Reviews\Reviews\Data as Reviews_Data;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Review_Listing_Render extends Base_Render {

	/**
	 * [$name description]
	 * @var string
	 */
	protected $name = 'review-listing-render';

	/**
	 * [init description]
	 * @return [type] [description]
	 */
	public function init() {}

	/**
	 * [get_name description]
	 * @return [type] [description]
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * [render description]
	 * @return [type] [description]
	 */
	public function render() {

		$uniqid = uniqid();

		$source = $this->get( 'source' );

		$source_instance = jet_reviews()->reviews_manager->sources->get_source_instance( $source );

		if ( ! $source_instance ) {
			echo __( 'Any Sources not found', 'jet-reviews' );

			return;
		}

		$source      = $source_instance->get_slug();
		$source_id   = $source_instance->get_current_id();
		$source_type = $source_instance->get_type();

		if ( 'jet-theme-core' === $source_type ) {
			echo __( 'JetReviews unavailable for jetThemeCore template preview', 'jet-reviews' );

			return;
		}

		$source_settings = jet_reviews()->settings->get_source_settings_data( $source_instance->get_slug(), $source_type );

		if ( ! $source_settings['allowed'] ) {
			echo __( 'JetReviews unavailable for this source type', 'jet-reviews' );

			return;
		}

		$raw_user_data = jet_reviews()->user_manager->get_raw_user_data();

		$user_can_review_data = jet_reviews()->user_manager->is_user_can_review( $source_instance->get_slug(), $raw_user_data );

		$reviews_per_page = $this->get( 'reviewsPerPage', 10 );

		$reviews_list_data = Reviews_Data::get_instance()->get_public_reviews_list( $source, $source_id, 0, $reviews_per_page  );

		$options = array(
			'uniqId'     => $uniqid,
			'sourceData' => [
				'source'          => $source,
				'sourceId'        => $source_id,
				'sourceType'      => $source_type,
				'allowed'         => $source_settings[ 'allowed' ],
				'commentsAllowed' => $source_settings[ 'comments_allowed' ],
				'approvalAllowed' => $source_settings[ 'approval_allowed' ],
				'itemLabel'       => $source_instance->get_item_label(),
				'itemThumb'       => $source_instance->get_item_thumb_url(),
            ],
			'userData' => [
				'id'        => $raw_user_data[ 'id' ],
				'name'      => $raw_user_data[ 'name' ],
				'mail'      => $raw_user_data[ 'mail' ],
				'avatar'    => $raw_user_data[ 'avatar' ],
				'roles'     => $raw_user_data[ 'roles' ],
				'canReview' => [
					'allowed' => $user_can_review_data['allowed'],
					'message' => $user_can_review_data['message'],
				],
				'canComment' => [
					'allowed' => true,
					'message' => 'This user can comment reviews',
				],
				'canRate' => [
					'allowed' => true,
					'message' => 'This user can rate reviews',
				],
            ],
			'reviewsListData'            => $reviews_list_data,
			'ratingLayout'               => $this->get( 'ratingLayout', 'stars-field' ),
			'ratingInputType'            => $this->get( 'ratingInputType', 'slider-input' ),
			'reviewRatingType'           => $this->get( 'reviewRatingType', 'average' ),
			'pageSize'                   => $reviews_per_page,
			'reviewAuthorAvatarVisible'  => $this->get( 'reviewAuthorAvatarVisible', true ),
			'reviewTitleVisible'         => $this->get( 'reviewTitleVisible', true ),
			'commentAuthorAvatarVisible' => $this->get( 'commentAuthorAvatarVisible', true ),
			'labels'                     => $this->get( 'labels' ),
		);

		?><script type="text/javascript">
			var jetReviewsWidget<?php echo $uniqid; ?>=<?php echo json_encode( $options ); ?>;
        </script><?php

		$icons_data = $this->get( 'icons' );

		$icons_html = '';

		foreach ( $icons_data as $slug => $icon_data ) {
			$icons_html .= sprintf( '<div ref="%s">%s</div>', $slug, jet_reviews_tools()->get_elementor_icon_html( $icon_data ) );
		}

		$widget_refs = sprintf( '<div class="jet-reviews-advanced__refs">%s</div>', $icons_html );

		if ( $source_settings['structuredata'] ) {
		    $this->render_structure_data( $reviews_list_data, $source_instance, $source_settings['structuredata_type'] );
		}

		require jet_reviews()->plugin_path( 'templates/public/widgets/jet-reviews-advanced-widget.php' );

	}

	/**
	 * @param false $reviews_list_data
	 * @param false $source_instance
	 * @param string $type
	 *
	 * @return false
	 */
	public function render_structure_data( $reviews_list_data = false, $source_instance = false, $type = 'Product' ) {

		if ( ! $reviews_list_data ) {
		    return false;
		}

		$source      = $source_instance->get_slug();
		$source_id   = $source_instance->get_current_id();
		$review_list = $reviews_list_data['list'];
		$total       = $reviews_list_data['total'];
		$rating      = 5 * intval( $reviews_list_data['rating'] ) / 100;

		$review_items =  array_map( function( $item ) {
            return [
	            '@type'         => 'Review',
	            'name'          => $item[ 'title' ],
	            'reviewBody'    => $item[ 'content' ],
	            'reviewRating'  => [
		            '@type'       => 'Rating',
		            'ratingValue' => strval( 5 * intval( $item[ 'rating' ] ) / 100 ),
		            'bestRating'  => '5',
		            'worstRating' => '0',
	            ],
	            'datePublished' => $item[ 'date' ][ 'raw' ],
	            'author'        => [
		            '@type' => 'Person',
		            'name'  => $item[ 'author' ][ 'name' ],
	            ],
            ];
        }, $review_list );

		$structure_data = [
			'@context'    => 'https://schema.org',
			'@type'       => $type,
			'name'        => $source_instance->get_item_label(),
			'image'       => $source_instance->get_item_thumb_url(),
            'aggregateRating' => [
	            '@type'       => 'AggregateRating',
                'bestRating'  => '5',
                'ratingCount' => strval( $total ),
                'ratingValue' => strval( $rating ),
                'reviewCount' => strval( $total ),
            ],
            'review' => $review_items,
		];

		printf( '<script type="application/ld+json">%s</script>', json_encode( $structure_data ) );
	}
}
