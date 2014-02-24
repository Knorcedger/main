/*global module:false*/
module.exports = function(grunt) {
	
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-ngmin');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-htmlmin');
	grunt.loadNpmTasks('grunt-string-replace');
	grunt.loadNpmTasks('grunt-contrib-clean');

	var root = 'platforms/android/assets/www/js/';
	var jsFiles = ['app.js', 'controllers/*.js', 'directives/*.js', 'filters/*.js', 'modules/*.js', 'services/*.js', '/modules/**/*.js', 'services/**/*.js'];
	for (var i = 0, length = jsFiles.length; i < length; i++) {
		jsFiles[i] = root + jsFiles[i];
	}

	// Project configuration.
	grunt.initConfig({
		jshint: {
			all: jsFiles,
			options: {
				curly: true,
				eqeqeq: true,
				eqnull: true,
				browser: true,
				globals: {
					jQuery: true
				},
				smarttabs: true,
				loopfunc: true,
				trailing: true
			}
		},
		clean: {
			build: [],
			dev: [root + '../viewsMin', root + 'compiled.min.js', root + "concatenated.js", root + "all.js"]
		},
		ngmin: {
			build: {
				src: jsFiles,
				dest: root + 'concatenated.js'
			}
		},
		concat: {
			build: {
				src: [
					root + '../cordova.js',
					root + 'libraries/angular.min.js',
					root + 'libraries/angular-route.min.js',
					root + 'libraries/angular-animate.min.js',
					root + 'libraries/angular-touch.min.js',
					root + 'libraries/lodash.min.js',
					root + 'libraries/angular-translate.js',
					root + 'libraries/angular-translate-loader-url.js',
					root + 'libraries/messageformat.js',
					root + 'libraries/angular-translate-interpolation-messageformat.js',
					root + 'concatenated.js'],
				dest: root + 'all.js',
			}
		},
		uglify: {
			options: {
				mangle: false
			},
			build: {
				files: {
					'platforms/android/assets/www/js/compiled.min.js': [root + 'all.js']
				}
			}
		},
		htmlmin: {
			build: {
				options: {
					removeComments: true,
					collapseWhitespace: true
				},
				files: [{
					expand: true,
					cwd: root + '../views/',
					dest: root + '../viewsMin',
					src: '*.html'
				}]
			}
		},
		'string-replace': {
			build: {
				files: [{
					expand: true,
					cwd: 'platforms/android/assets/www/',
					dest: 'platforms/android/assets/www/',
					src: 'index.html'
				}],
				options: {
					replacements: [
						//comment scripts
						{
							pattern: /<script src=/g,
							replacement: '<!--<script src='
						}, {
							pattern: /script>/g,
							replacement: 'script>-->'
						}, {
							pattern: '</head>',
							replacement: '<script src="js/compiled.min.js"></script>\n\r</head>'
						}
					]
				}
			},
			dev: {
				files: [{
					expand: true,
					cwd: 'platforms/android/assets/www/',
					dest: 'platforms/android/assets/www/',
					src: 'index.html'
				}],
				options: {
					replacements: [{
						pattern: /<!--<script src=/g,
						replacement: '<script src='
					}, {
						pattern: /script>-->/g,
						replacement: 'script>'
					}, {
						pattern: '<script src="js/compiled.min.js"></script>\n\r',
						replacement: ''
					}]
				}
			},
			buildViews: {
				files: [{
					expand: true,
					cwd: root,
					dest: root,
					src: 'app.js'
				}, {
					expand: true,
					cwd: root + 'directives/',
					dest: root + 'directives/',
					src: '*.js'
				}, {
					expand: true,
					cwd: root + 'modules/',
					dest: root + 'modules/',
					src: '*.js'
				}, {
					expand: true,
					cwd: root + '../views/',
					dest: root + '../views/',
					src: '*.html'
				}],
				options: {
					replacements: [
						{
							pattern: /(views\/)(\w*)(.html)/gi,
							replacement: 'viewsMin/$2$3'
						}
					]
				}
			},
			devViews: {
				files: [{
					expand: true,
					cwd: root,
					dest: root,
					src: 'app.js'
				}, {
					expand: true,
					cwd: root + 'directives/',
					dest: root + 'directives/',
					src: '*.js'
				}, {
					expand: true,
					cwd: root + 'modules/',
					dest: root + 'modules/',
					src: '*.js'
				}, {
					expand: true,
					cwd: root + '../views/',
					dest: root + '../views/',
					src: '*.html'
				}],
				options: {
					replacements: [
						{
							pattern: /(viewsMin\/)(\w*)(.html)/gi,
							replacement: 'views/$2$3'
						}
					]
				}
			},
			disableDebug: {
				files: [{
					expand: true,
					cwd: root,
					dest: root,
					src: 'app.js'
				}],
				options: {
					replacements: [
						{
							pattern: /logProvider.debug = true;/,
							replacement: 'logProvider.debug = false'
						},
						{
							pattern: /mode: 'debug'/,
							replacement: "mode: 'production'"
						}
					]
				}
			},
			enableDebug: {
				files: [{
					expand: true,
					cwd: root,
					dest: root,
					src: 'app.js'
				}],
				options: {
					replacements: [
						{
							pattern: /logProvider.debug = false/,
							replacement: 'logProvider.debug = true;'
						},
						{
							pattern: /mode: 'production'/,
							replacement: "mode: 'debug'"
						}
					]
				}
			}
		}
	});
	
	// Default task.
	grunt.registerTask('default', ['jshint']);
	grunt.registerTask('jsHint', ['jshint']);
	grunt.registerTask('build', ['jshint', 'string-replace:disableDebug', 'string-replace:buildViews', 'ngmin:build', 'concat:build', 'uglify:build', 'string-replace:build', 'htmlmin:build']);
	grunt.registerTask('dev', ['string-replace:enableDebug', 'string-replace:devViews', 'string-replace:dev', 'clean:dev']);
	
};