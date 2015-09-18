module.exports = function(grunt) {

    var js_frontend = [
      './bower_components/bootstrap/js/transition.js',
      './bower_components/bootstrap/js/alert.js',
      './bower_components/bootstrap/js/button.js',
      './bower_components/bootstrap/js/carousel.js',
      './bower_components/bootstrap/js/collapse.js',
      './bower_components/bootstrap/js/dropdown.js',
      './bower_components/bootstrap/js/modal.js',
      './bower_components/bootstrap/js/tooltip.js',
      './bower_components/bootstrap/js/popover.js',
      './bower_components/bootstrap/js/scrollspy.js',
      './bower_components/bootstrap/js/tab.js',
      './bower_components/bootstrap/js/affix.js',
      './bower_components/bootstrap-touchspin/src/jquery.bootstrap-touchspin.js',
      './bower_components/bootbox.js/bootbox.js',
      './app/assets/js/frontend.js'
    ];

  // Initialize configuration object
    grunt.initConfig({


    // Compiles LESS to CSS
    less: {
        development: {
            options: {
              compress: false,  // Minification
            },
            files: {
              "public/assets/css/frontend.css": "app/assets/less/frontend.less",
            }
        }
    },


    // Autoprefixes CSS
    autoprefixer: {

      single_file: {
        options: {
          browsers: ['> 1%', 'last 8 versions', 'Firefox >= 20', 'ie 8', 'ie 9', 'Android 2.3'],
        },
        src: 'public/assets/css/frontend.css',
        dest: 'public/assets/css/frontend-prefixed.css'
      }
    },


    // Minfies autoprefixed CSS for Production
    cssmin: {
      options: {
        keepSpecialComments: 0
      },
      target: {
        files: {
          'public/assets/css/frontend-prefixed.min.css': 'public/assets/css/frontend-prefixed.css',
        }
      }
    },


    // Concatenates files
    concat: {
      options: {
        separator: ';',
      },
      js_frontend: {
        src: js_frontend,
        dest: './public/assets/js/frontend.js',
      },
    },


    // Minifies JavaScript files
    uglify: {
      options: {
        mangle: false,  // Leaves function and variable names unchanged
      },
      frontend: {
        files: [ {
          './public/assets/js/frontend.min.js': './public/assets/js/frontend.js',
        }, {
            expand: true,
            flatten: true,
            cwd: '.',
            src: [ 'app/assets/js/pages/*.js' ],
            dest: './public/assets/js/pages',
            ext: '.min.js'
        }]
      }
    },


    // Add banner to minified files
    usebanner: {
      taskName: {
        options: {
          position: 'top',
          banner:  '/* Last update: <%= grunt.template.today("yyyy-mm-dd") %> */\n',
        },
        files: {
          src: [ 'public/assets/css/frontend-prefixed.min.css' ]
        }
      }
    },


    // Minifies imnages
    imagemin: {
      dynamic: {
        files: [{
            expand: true,
            // Compresses all png / jpg / gif images
            cwd: './app/assets/img/',
            src: ['**/*.{png,jpg,gif}'],
            dest:'./public/assets/img/'
        }]
      }
    },


    copy: {
        fonts: {
            files: [{
                expand: true,
                flatten: true,
                cwd: '.',
                dest: './public/assets/fonts/',
                src: [
                    'bower_components/bootstrap/fonts/*',
                    'bower_components/font-awesome/fonts/*'
                ]
            }]
        },
        jquery: {
            files: [{
                expand: true,
                flatten: true,
                cwd: '.',
                dest: './public/assets/js/',
                src: [ 'bower_components/jquery/dist/*' ]
            }]
        },
        js_pages: {
            files: [{
                expand: true,
                flatten: true,
                cwd: '.',
                dest: './public/assets/js/pages/',
                src: [ 'app/assets/js/pages/*.js' ]
            }]
        }
    },

    // Run predefined tasks on event
    watch: {

    	// Enables Livereload
      	options: {
        	livereload: true,
      	},

        less: {
         	files: './app/assets/less/*.less',
         	tasks: ['less', 'autoprefixer', 'cssmin', 'usebanner'],
        },

        scripts: {
          files: [
            './bower_components/bootstrap/dist/js/*.js',
            './bower_components/bootstrap-touchspin/src/*.js',
            './app/assets/js/**/*.js'
          ],
        	tasks: ['concat', 'copy:js_pages', 'uglify' ],
      	},

        images: {
          	files: ['./app/assets/img/**/*.{png,jpg,gif}'],
          	tasks: ['imagemin'],
        },

        html: {
          	files: ['*.html', '*.php'],
        },
      }
    });


  // Load plugins
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-banner');
  grunt.loadNpmTasks('grunt-contrib-imagemin');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Compile CSS and Javascript
  grunt.registerTask('compile', ['less', 'autoprefixer', 'cssmin', 'concat', 'copy', 'uglify', 'usebanner', 'imagemin']);

  // Set default task
  grunt.registerTask('default', ['watch']);

};
