import { useBlockProps } from "@wordpress/block-editor";
import { useEffect, useState } from "@wordpress/element";
import { Spinner, Disabled } from "@wordpress/components";
import BlockInspector from "./inspector";
import { __ } from "@wordpress/i18n";
import { dateI18n, __experimentalGetSettings } from "@wordpress/date";

export default (props) => {
	const { attributes, setAttributes, className, isSelected, clientId } =
		props;

	const { showTitle, showId, showFname, showLname, showEmail, showDate } =
		attributes;

	const [title, setTitle] = useState([]);
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
	// console.log({ toggleColumns });

	useEffect(() => {
		const fetchChallenges = async () => {
			const response = await fetch(
				`${miusage.siteURL}/wp-json/miusage/v1/challenges`
			);
			const data = await response.json();
			const rows = Object.values(data?.data?.rows);
			let headers = Object.values(data?.data?.headers);
			console.log(rows, headers);
			headers = Object.keys(rows[0]).map((key, index) => ({
				[key]: headers[index],
			}));
			setRows(rows);
			setHeaders(headers);
			setTitle(data?.title);
		};
		fetchChallenges();
	}, []);

	const dateFormat = __experimentalGetSettings().formats.date;

	return (
		<div className={className} {...blockProps}>
			<BlockInspector
				{...{ attributes, setAttributes, className, isSelected }}
			/>

			<Disabled>
				<div className="miusage-challenge-data">
					<table className="miusage-challenge-data-table">
						{showTitle && title && <caption>{title}</caption>}
						<thead>
							<tr>
								{headers.map((header) => {
									let showData =
										toggleColumns[Object.keys(header)[0]];
									let label = Object.values(header)[0];
									if (showData) {
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
										<td>
											{dateI18n(
												dateFormat,
												row.date * 1000
											)}
										</td>
									)}
								</tr>
							))}
						</tbody>
					</table>
				</div>
			</Disabled>

			{rows.length === 0 && <Spinner />}
		</div>
	);
};
