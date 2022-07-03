const defaultConfig = require("@wordpress/scripts/config/webpack.config");

const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const path = require("path");

const APP_DIR = path.resolve(__dirname, "assets/");

module.exports = {
	...defaultConfig,
	entry: {
		blocks: `${APP_DIR}/blocks/blocks.js`,
	},
	output: {
		...defaultConfig.output,
		path: path.resolve(process.cwd(), `${APP_DIR}/build`),
	},
	plugins: [
		...defaultConfig.plugins,
		new MiniCssExtractPlugin({
			// Options similar to the same options in webpackOptions.output
			// all options are optional
			filename: "[name].css",
			chunkFilename: "[id].css",
			ignoreOrder: false, // Enable to remove warnings about conflicting order
		}),
	],
	module: {
		...defaultConfig.module,
		rules: [
			...defaultConfig.module.rules,
			{
				test: /\.(png|svg|jpg|gif)$/,
				use: ["file-loader"],
			},
		],
	},
};
