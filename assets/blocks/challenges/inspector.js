import { InspectorControls } from "@wordpress/block-editor";
import { PanelBody, ToggleControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

export default (props) => {
	const { attributes, setAttributes } =
		props;

	const { showId, showFname, showLname, showEmail, showDate } =
		attributes;

	const toggleFields = [
		{
			name: "showId",
			label: __("Show ID", "miusage"),
			checked: showId,
		},
		{
			name: "showFname",
			label: __("Show First Name", "miusage"),
			checked: showFname,
		},
		{
			name: "showLname",
			label: __("Show Last Name", "miusage"),
			checked: showLname,
		},
		{
			name: "showEmail",
			label: __("Show Email", "miusage"),
			checked: showEmail,
		},
		{
			name: "showDate",
			label: __("Show Date", "miusage"),
			checked: showDate,
		},
	];

	return (
		<InspectorControls>
			<PanelBody title={__("Toggle Settings", "miusage")} initialOpen={true}>
				{toggleFields?.map((field, index) => (
					<ToggleControl
						key={index}
						label={field.label}
						checked={field.checked}
						onChange={() => {
							setAttributes({
								[field.name]: !field.checked,
							});
						}}
					/>
				))}
			</PanelBody>
		</InspectorControls>
	);
};
