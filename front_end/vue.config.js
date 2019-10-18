// const webpack = require('webpack')
const StatsPlugin = require('stats-webpack-plugin')
module.exports = {
	productionSourceMap: false,

	css: {
		sourceMap: false,
	},

    configureWebpack: {
      plugins: [new StatsPlugin('stats.json', {
            chunkModules: true,
            chunks: true,
            assets: false, 
            modules: true,
            children: true,
            chunksSort: true, 
            assetsSort: true
        })]
    },
}
