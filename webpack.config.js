var path = require('path')
var webpack = require('webpack')
var ExtractTextPlugin = require('extract-text-webpack-plugin')
var OptimizeCSSPlugin = require('optimize-css-assets-webpack-plugin')
var isProduction = process.env.NODE_ENV === 'production';

module.exports = {
	entry: './src/main.ts',
	output: {
		path: path.resolve(__dirname, './assets'),
		publicPath: 'http://localhost:8080/assets/',
		filename: '[name].js'
	},
	module: {
		rules: [{
				test: /\.vue$/,
				loader: 'vue-loader',
				options: {
					loaders: isProduction ? {
						'css': ExtractTextPlugin.extract({
							fallback: 'vue-style-loader',
							use: 'css-loader'
						}),
						// Since sass-loader (weirdly) has SCSS as its default parse mode, we map
						// the "scss" and "sass" values for the lang attribute to the right configs here.
						// other preprocessors should work out of the box, no loader config like this necessary.
						'scss': ExtractTextPlugin.extract({
							fallback: 'vue-style-loader',
							use: 'css-loader!sass-loader'
						}),
						'sass': ExtractTextPlugin.extract({
							fallback: 'vue-style-loader',
							use: 'css-loader!sass-loader?indentedSyntax'
						})
					} : {}
				}
			},
			{
				test: /\.js$/,
				loader: 'babel-loader',
				exclude: [/node_modules/, /assets/]
			},
			{
				test: /\.ts$/,
				loader: 'ts-loader',
				options: {
					appendTsSuffixTo: [/\.vue$/]
				},
				exclude: /node_modules/
			},
			{
				test: /\.(png|jpg|gif|svg)$/,
				loader: 'file-loader',
				options: {
					name: '[name].[ext]?[hash]'
				}
			}
		]
	},
	resolve: {
		extensions: [".ts", ".js", ".vue", ".json"],
		alias: {
			'vue$': 'vue/dist/vue.esm.js'
		}
	},
	devServer: {
		historyApiFallback: true,
		noInfo: true,
		headers: {
			'Access-Control-Allow-Origin': '*',
		},
		proxy: {
			"**": "http://localhost/wordpress/"
		}
	},
	performance: {
		hints: false
	},
	devtool: '#eval-source-map',
	plugins: [
		new webpack.NamedModulesPlugin()
	]
}

if (isProduction) {
	module.exports.devtool = '#source-map';

	module.exports.output.publicPath = './wp-content/plugins/etsy-shop-widget/assets/';

	// http://vue-loader.vuejs.org/en/workflow/production.html
	module.exports.plugins = (module.exports.plugins || []).concat([
		new webpack.DefinePlugin({
			'process.env': {
				NODE_ENV: '"production"'
			}
		}),
		new webpack.optimize.UglifyJsPlugin({
			sourceMap: true,
			compress: {
				warnings: false
			}
		}),
		new webpack.LoaderOptionsPlugin({
			minimize: true
		}),
		// extract css into its own file
		new ExtractTextPlugin('style.css'),
		// Compress extracted CSS. We are using this plugin so that possible
		// duplicated CSS from different components can be deduped.
		new OptimizeCSSPlugin(),
		// split vendor js into its own file
		new webpack.optimize.CommonsChunkPlugin({
			name: 'vendor',
			minChunks: function (module, count) {
				// any required modules inside node_modules are extracted to vendor
				return (
					module.resource &&
					/\.js$/.test(module.resource) &&
					module.resource.indexOf(path.join(__dirname, './node_modules')) === 0
				)
			}
		})
	])
}