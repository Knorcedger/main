module.exports = function(grunt) {

	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-nodemon');

	// Project configuration.
	grunt.initConfig({
		jshint: {
			all: ['app.js', 'modules/*.js', 'v1/*.js'],
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
				trailing: true,
				evil: true
			}
		},
		nodemon: {
			dev: {
				script: 'app.js',
				options: {
					ext: 'js, json',
					nodeArgs: ['--debug']
				}
			}
		}
	});


	// Default task(s).
	grunt.registerTask('default', ['jshint']);
	grunt.registerTask('run', ['nodemon']);

};