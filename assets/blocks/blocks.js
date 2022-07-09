import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import Challenges from "./challenges/edit";

const blocks = [
	{
		title: __("Misuage Challenges", "miusage"),
		description: __("Misuage Challenges", "miusage"),
		icon: "rest-api",
		namespace: "challenges",
		keywords: [
			__("Misuage Challenges", "miusage"),
			__("Miusage", "miusage"),
		],
		Component: Challenges,
	}
];

blocks.forEach((block) => {
	registerBlockType(`miusage/${block.namespace}`, {
		title: block.title,
		description: block.description,
		icon: block.icon,
		category: "miusage",
		keywords: [...block.keywords],
		example: {
			attributes: {},
		},
		edit: block.Component,
		save: (() => null),
	});
});
