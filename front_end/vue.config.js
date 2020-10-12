const webpack = require("webpack");
const CompressionPlugin = require("compression-webpack-plugin");
const UglifyJsPlugin = require("uglifyjs-webpack-plugin");
const StatsPlugin = require("stats-webpack-plugin");

module.exports = {
  productionSourceMap: false,

  css: {
    sourceMap: false,
  },

  configureWebpack: (config) => {
    let proPlugin = [
      new CompressionPlugin({
        test: /.(js|css|svg|woff|ttf|json|html|otf)$/,
        // threshold: 10240,
        filename: '[path].gz[query]', 
        algorithm: 'gzip',
        minRatio: 1,
        deleteOriginalAssets: false,
      }),
      new UglifyJsPlugin({
        uglifyOptions: {
          compress: {
            drop_debugger: true,
            drop_console: true,
          },
        },
        sourceMap: false,
        parallel: true,
      }),
      new StatsPlugin("stats.json", {
        chunkModules: true,
        chunks: true,
        assets: false,
        modules: true,
        children: true,
        chunksSort: true,
        assetsSort: true,
      }),
    ];
    let devPlugin = [new webpack.HotModuleReplacementPlugin()];
    if (process.env.NODE_ENV === "test" || process.env.NODE_ENV === "mock") {
      // 开发环境
      config.plugins = [...config.plugins, ...devPlugin];

      config.devServer = { https: true };

      config.devServer.proxy =
        process.env.NODE_ENV === "test"
          ? {
              "/api/oj": {
                target: "https://acmwhut.com/",
                changeOrigin: true,
                secure: false,
              },
            }
          : {
              "/api/oj": {
                target: "http://localhost:3000/",
                changeOrigin: true,
                pathRewrite: {
                  "^/api/oj": "",
                },
              },
            };
    } else {
      // 生产环境
      config.plugins = [...config.plugins, ...proPlugin];
    }
  },
};
