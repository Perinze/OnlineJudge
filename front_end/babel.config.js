module.exports = {
  presets: [
  	['@babel/preset-env', { 'modules': false }],
    '@vue/app'
  ],
  'plugins': [
    [
      'component',
      {
        'libraryName': 'element-ui',
        'styleLibraryName': 'theme-chalk'
      }
    ]
  ]
}
