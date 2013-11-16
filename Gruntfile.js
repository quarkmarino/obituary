module.exports = function(grunt) {
	// Do grunt-related things in here
	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		less: {
			development: {
				options: {
					paths: ["components/bootstrap/less"]
				},
				files: {
					"path/to/result.css": "path/to/source.less"
				}
			},
			production: {
				options: {
					paths: ["assets/css"],
					cleancss: true
				},
				files: {
					"path/to/result.css": "path/to/source.less"
				}
			}
		},
		concat: {
		  options: {
		    // define a string to put between each file in the concatenated output
		    separator: ';'
		  },
		  dist: {
		    // the files to concatenate
		    src: ['dist/<%= pkg.name %>.min.js'],
		    // the location of the resulting JS file
		    dest: 'dist/<%= pkg.name %>.js'
		  }
		},
		uglify: {
			options: {
				// the banner is inserted at the top of the output
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
			},
			/*build: {
				src: 'src/<%= pkg.name %>.js',
				dest: 'build/<%= pkg.name %>.min.js'
			},*/
			dist: {
				files: {
					'public/assets/js/<%= pkg.name %>.min.js': ['public/assets/js/settings-panel.js'/*, '<%= concat.dist.dest %>'*/]
				}
			}
		},
		cssmin: {
			combine: {
				files: {
					'public/assets/css/<%= pkg.name %>.min.css': ['public/assets/css/settings-panel.css', 'public/assets/css/styles-bluegreen.css']
				}
			}
		}
	});

	// Load the plugin that provides the "uglify" task.
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');

	// Default task(s).
	//grunt.registerTask('default', ['less', 'concat', 'cssmin', 'uglify']);
	grunt.registerTask('default', ['uglify', 'cssmin']);

	// A very basic default task.
  /*grunt.registerTask('default', 'Log some stuff.', function() {
    grunt.log.write('Logging some stuff...').ok();
  });*/
};