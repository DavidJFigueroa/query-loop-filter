<?php


$selectedTaxonomy = isset($attributes['selectedTaxonomy']) ? $attributes['selectedTaxonomy'] : '';

$terms = get_terms(
	array(
		'taxonomy' => $selectedTaxonomy,
		'hide_empty' => true,
	)
);





?>

<div class="query-loop-filter-block">
	<div>
		<!-- Alle anzeigen should reset the filters but still apply the selected taxonomy -->
		<button onclick="resetFilters()">Alle anzeigen</button>
	</div>
	<div>
		<!-- Render taxonomy term buttons -->
		<?php foreach ($terms as $term) { ?>
			<button onclick="filterByTerm('<?php echo esc_js($term->slug); ?>')">
				<?php echo esc_html($term->name); ?>
			</button>
		<?php } ?>
	</div>
</div>

<script>
	// Function to apply a filter by term
	function filterByTerm(term) {
		// Reload the page with the selected taxonomy term as a query parameter
		const urlParams = new URLSearchParams(window.location.search);
		urlParams.set('filter_term', term);
		urlParams.set('taxonomy', '<?php echo esc_js($selectedTaxonomy); ?>');
		window.location.search = urlParams.toString();
	}

	// Function to reset filters but still respect the selected taxonomy
	function resetFilters() {
		const urlParams = new URLSearchParams(window.location.search);
		urlParams.delete('filter_term'); // Remove specific term filter
		urlParams.set('taxonomy', '<?php echo esc_js($selectedTaxonomy); ?>'); // Ensure taxonomy is still set
		window.location.search = urlParams.toString();
	}
</script>