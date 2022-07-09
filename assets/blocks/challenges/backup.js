import { useBlockProps } from "@wordpress/block-editor";
import { useEffect, useState } from "@wordpress/element";
import { Disabled } from "@wordpress/components";
import BlockInspector from "./inspector";
import { __ } from "@wordpress/i18n";

export default (props) => {
	const { attributes, setAttributes, className, isSelected, clientId } =
		props;

	const { showTitle, showId, showFname, showLname, showEmail, showDate } =
		attributes;

	// const toggleColumns = {
	// 	id: showId,
	// 	fname: showFname,
	// 	lname: showLname,
	// 	email: showEmail,
	// 	date: showDate,
	// };

	const toggleColumns = {
		id: {
			label: "ID",
			show: showId,
		},
		fname: {
			label: "First Name",
			show: showFname,
		},
		lname: {
			label: "Last Name",
			show: showLname,
		},
		email: {
			label: "Email",
			show: showEmail,
		},
		date: {
			label: "Date",
			show: showDate,
		},
	};

	const [challenges, setChallenges] = useState([]);
	const [headers, setHeaders] = useState([]);
	const [rows, setRows] = useState([]);
	const blockProps = useBlockProps();

	useEffect(() => {
		const fetchChallenges = async () => {
			const response = await fetch(
				`${miusage.siteURL}/wp-json/miusage/v1/challenges`
			);
			const data = await response.json();
			const rows = Object.values(data.data.rows);
			const headers = Object.values(data.data.headers);
			setRows(rows);
			setHeaders(headers);
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
											(header, index) => {
												return (
													<th key={index}>
													{header}
												</th>
												)
											}

										)}
									</tr>
								</thead>
								<tbody>
									{challenges?.data?.rows &&
										Object.values(
											challenges?.data?.rows
										).map((row, index) => (
											<tr key={index}>
												{console.log(row, 'row')}
												{Object.values(row).map(
													(cell, cellIndex) => (
														<td key={cellIndex}>
															{cell}
														</td>
													)
												)}
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
