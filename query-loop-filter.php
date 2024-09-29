<?php

/**
 * Plugin Name:       Query Loop Filter
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.6
 * Requires PHP:      7.2
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       query-loop-filter
 *
 * @package CreateBlock
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_query_loop_filter_block_init()
{
	register_block_type(__DIR__ . '/build');
}
add_action('init', 'create_block_query_loop_filter_block_init');



add_filter('pre_render_block', "webx_custom_query_pre_render_block", 10, 2);
function webx_custom_query_pre_render_block($pre_render, $block)
{

	if ($block['blockName'] === 'create-block/query-loop-filter') {

		add_filter('query_loop_block_query_vars', function ($query) use ($block) {


			$selectedTaxonomy = sanitize_text_field($block['attrs']['selectedTaxonomy']);

			//$selectedTaxonomy = isset($_GET['taxonomy']) ? sanitize_text_field($_GET['taxonomy']) : '';
			$filterTerm = isset($_GET['filter_term']) ? sanitize_text_field($_GET['filter_term']) : '';

			if (!empty($filterTerm) && !empty($selectedTaxonomy)) {
				// Filter by the selected term in the URL
				$query['tax_query'] = array(
					array(
						'taxonomy' => $selectedTaxonomy,
						'field'    => 'slug',
						'terms'    => $filterTerm,
					)
				);
			} elseif (!empty($selectedTaxonomy)) {
				$query['tax_query'] = array(
					array(
						'taxonomy' => $selectedTaxonomy,
						'operator' => 'EXISTS',
					)
				);
			}
			return $query;
		});
	}
	return $pre_render;
}



/*

add_filter('rest_property_query', function ($args, $request) {
	$request->get_param('taxonomy');

	$args['tax_query'] = [
		[
			'taxonomy' => 'hotel_category',
			'operator' => 'EXISTS',
		]
	];
	return $args;
}, 10, 2);
*/