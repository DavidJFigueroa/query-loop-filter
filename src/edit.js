import { __ } from "@wordpress/i18n";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { PanelBody, SelectControl } from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import { store as coreDataStore } from "@wordpress/core-data";
import "./editor.scss";

export default function Edit({ attributes, setAttributes, context }) {
	const blockProps = useBlockProps();
	const { query } = context;
	const { selectedTaxonomy } = attributes;
	const taxonomies = useSelect((select) => {
		return select(coreDataStore).getTaxonomies({ type: query.postType }, [
			query.postType,
		]);
	});

	// Log context and taxonomies to the console
	//console.log("Context:", context);
	// console.log("Post Type:", query.postType);
	// console.log("Taxonomies:", taxonomies);

	const onChangeSelectValue = (newValue) => {
		setAttributes({ selectedTaxonomy: newValue });
	};

	//console.log("Selected Taxonomy:", selectedTaxonomy);

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={__("Filter Settings", "query-loop-filter")}
					initialOpen={true}
				>
					<SelectControl
						label={__("Select Taxonomy", "query-loop-filter")}
						value={selectedTaxonomy}
						options={
							taxonomies
								? taxonomies.map((taxonomy) => ({
										label: taxonomy.name,
										value: taxonomy.slug,
								  }))
								: []
						}
						onChange={onChangeSelectValue}
					/>
				</PanelBody>
			</InspectorControls>
			<p {...blockProps}>
				{__("Query Loop Filter – hello from the editor!", "query-loop-filter")}
			</p>
		</>
	);
}
