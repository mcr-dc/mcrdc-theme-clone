/**
 * The Huron configuration file.
 */

// Requires
path = require('path');

/**
 * A configuration object for your Huron settings.
 * For a detailed explanation,
 * @see  https://github.com/alleyinteractive/huron/blob/master/config/README.md
 */
module.exports = {
  css: [],
  entry: 'global',
  js: [],
  kss: 'client/sass',
  kssExtension: '.scss',
  kssOptions: {
    multiline: true,
    markdown: true,
    custom: ['data'],
  },
  output: 'partials',
  port: 8080,
  prototypes: ['sample'],
  root: 'static/prototype',
  templates: {
    rule: {
      test: /\.(hbs|handlebars)$/,
      use: 'handlebars-template-loader',
    },
    extension: '.hbs',
  },
  window: {},
};

