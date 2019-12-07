// Require path.
const path = require( 'path' );
const wpPot = require('wp-pot');

// Configuration object.
const config = {
	context: __dirname,
	// Create the entry points.
	// One for frontend and one for the admin area.
	entry: {
		// frontend and admin will replace the [name] portion of the output config below.
		frontend: './src/front/front-index.js',
		admin: './src/admin/admin-index.js'
	},

	// Create the output files.
	// One for each of our entry points.
	output: {
		// [name] allows for the entry object keys to be used as file names.
		filename: 'js/[name].js',
		// Specify the path to the JS files.
		path: path.resolve( __dirname, 'assets' )
	},

	// Setup a loader to transpile down the latest and great JavaScript so older browsers
	// can understand it.
	module: {
		rules: [
			{
				// Look for any .js files.
				test: /\.js$/,
				// Exclude the node_modules folder.
				exclude: /node_modules/,
				// Use babel loader to transpile the JS files.
				loader: 'babel-loader'
			}
		]
	}
};

//// POT file.
wpPot( {
	package: 'Features for WordPress',
	domain: 'ffwp',
	destFile: 'i18n/languages/ffwp.pot',
	relativeTo: './',
	src: [ './**/*.php' ],
	bugReport: 'https://github.com/raftaar1191/features-for-wordpress/issues'
} );

// Export the config object.
module.exports = config;