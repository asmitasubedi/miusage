import { useBlockProps } from "@wordpress/block-editor";
import { useEffect, useState } from "@wordpress/element";
import { Spinner, Disabled } from "@wordpress/components";
import BlockInspector from "./inspector";
import { __ } from "@wordpress/i18n";
import { dateI18n, format, __experimentalGetSettings } from "@wordpress/date";
import _ from "lodash";

export default (props) => {
	const { attributes, setAttributes, className, isSelected, clientId } =
		props;

	const { showTitle, showId, showFname, showLname, showEmail, showDate } =
		attributes;

	const [challenges, setChallenges] = useState([]);
	const [headers, setHeaders] = useState([]);
	const [rows, setRows] = useState([]);
	const blockProps = useBlockProps();

	const toggleColumns = {
		id: showId,
		fname: showFname,
		lname: showLname,
		email: showEmail,
		date: showDate,
	};
	console.log({toggleColumns});

	useEffect(() => {
		const fetchChallenges = async () => {
			const response = await fetch(
				`${miusage.siteURL}/wp-json/miusage/v1/challenges`
			);
			const data = await response.json();
			const rows = Object.values(data?.data?.rows);
			let headers = Object.values(data?.data?.headers);
			headers = Object.keys(rows[0]).map((key, index) => ({ [key]: headers[index] }));
			setRows(rows);
			setHeaders(headers);
			setChallenges(data);
		};
		fetchChallenges();
	}, []);

	const dateFormat = __experimentalGetSettings().formats.date;

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
						{/* <header className="miusage-table-header">
							{showTitle && (
								<span className="miusage-table-title">
									{challenges?.title}
								</span>
							)}
						</header> */}
						<div className="miusage-table-body">
							<table>
								<thead>
									<tr>
										{headers.map((header) => {
											let showData = toggleColumns[Object.keys(header)[0]];
											let label = Object.values(header)[0];
											if( showData) {
												return <th>{label}</th>;
											}
										})}

									</tr>
								</thead>
								<tbody>
									{rows.map((row, index) => (
										<tr key={index}>
											{showId && <td>{row.id}</td>}
											{showFname && <td>{row.fname}</td>}
											{showLname && <td>{row.lname}</td>}
											{showEmail && <td>{row.email}</td>}
											{showDate && (
												<td
													dateTime={format(
														"c",
														row.date
													)}
													// className="wp-block-latest-posts__post-date"
												>
													{dateI18n(
														dateFormat,
														row.date
													)}
												</td>
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
				<Spinner />
			)}
		</div>
	);
};
