const webpack = require('webpack');
const CompressionPlugin = require("compression-webpack-plugin");
const UglifyJsPlugin = require("uglifyjs-webpack-plugin");
const StatsPlugin = require('stats-webpack-plugin');
module.exports = {
	productionSourceMap: false,

	css: {
		sourceMap: false,
	},

    configureWebpack: config => {
        let devPlugin = [
        	new webpack.HotModuleReplacementPlugin(),
	        new StatsPlugin('stats.json', {
	            chunkModules: true,
	            chunks: true,
	            assets: false,
	            modules: true,
	            children: true,
	            chunksSort: true,
	            assetsSort: true
	        }),
        ];
        let proPlugin = [
        	new webpack.HotModuleReplacementPlugin(),
	        new CompressionPlugin({
				test:/.(js|css|svg|woff|ttf|json|html|otf)$/,
				threshold:10240,
				deleteOriginalAssets:false,
			}),
			new UglifyJsPlugin({
				uglifyOptions: {
					compress: {
						drop_debugger: true,
						drop_console: true
					}},
				sourceMap: false,
				parallel: true
			})
		]
    	if(process.env.NODE_ENV === 'production') {
    		// 生产环境
			config.plugins = [...config.plugins, ...proPlugin];
    	}else{
    		// 开发环境
			config.plugins = [...config.plugins, ...devPlugin];
    	}
      
    },
}
