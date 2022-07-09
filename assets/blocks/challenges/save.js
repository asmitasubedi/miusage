import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";

export default ({ attributes, className }) => {
	const {} = attributes;
	const blockProps = useBlockProps.save();

	return (
		<div className={className} {...blockProps}>
			<div
				id={`miusage-challenges-table-style-${block_id}`}
				className={`miusage-challenges-table-wrapper ${className}`}
			></div>
		</div>
	);
};
