import { useBlockProps } from "@wordpress/block-editor";
import { useEffect, useState } from "@wordpress/element";
import { Disabled } from "@wordpress/components";
import BlockInspector from "./inspector";
import { __ } from "@wordpress/i18n";

export default (props) => {
	const { attributes, setAttributes, className, isSelected, clientId } =
		props;

	const { showTitle, showId, showFname, showLname, showEmail, showDate } = attributes;

	const [challenges, setChallenges] = useState([]);
	const blockProps = useBlockProps();

	useEffect(() => {
		const fetchChallenges = async () => {
			const response = await fetch(
				`${miusage.siteURL}/wp-json/miusage/v1/challenges`
			);
			const data = await response.json();
			console.log({ data });		
			setChallenges(data);
		};
		fetchChallenges();
	}, []);

	return (
		<div className={className} {...blockProps}>
			<BlockInspector
				{...{ attributes, setAttributes, className, isSelected }}
			/>
			<div
				id={`miusage-challenges-table-style-${clientId}`}
				className={`miusage-challenges-table-wrapper ${className}`}
			>
				<Disabled>
					<div className="miusage-table">
						<header className="miusage-table-header">
							{showTitle && (
								<h2 className="miusage-table-title">
									{challenges?.title}
								</h2>
							)}
						</header>
						<div className="miusage-table-body">
							<table>
								<thead>
									<tr>
										{challenges?.data?.headers.map(
											(header, index) => (
												<th key={index}>{header}</th>
											)
										)}
									</tr>
								</thead>
								<tbody>
									{challenges?.data?.rows && Object.values(challenges?.data?.rows).map((row, index) => (
										<tr key={index}>
											{console.log(row)}
											{Object.values(row).map((cell, cellIndex) => (
												<td key={cellIndex}>{cell}</td>
											))}
										</tr>
									))}
								</tbody>
							</table>
						</div>
					</div>
				</Disabled>
			</div>

			{challenges.length === 0 && (
				<p>
					{__(
						"Please wait while the challenges are being fetched.",
						"miusage"
					)}
				</p>
			)}
		</div>
	);
};
