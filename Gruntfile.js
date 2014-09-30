module.exports = function(grunt) {

    // 1. All configuration goes here
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        compass: {
          dev: {
            options: {
              sassDir: ['assets/css/scss'],
              cssDir: ['assets/css'],
              environment: 'development'
            }
          },

          prod: {
            options: {
              sassDir: ['assets/css/scss'],
              cssDir: ['assets/css'],
              environment: 'production'
            }
          },
        },

        uglify: {
          all: {
            files: {
              'assets/js/main.min.js': [
              'assets/js/frontend-scripts.js',
              'assets/js/main.js'
              ]
            }
          },
        },

        watch: {
          compass: {
            files: ['assets/css/scss/*.{scss,sass}'],
            tasks: ['compass:dev']
          },

          js: {
            files: ['assets/js/*.js'],
            tasks: ['uglify']
          }
        },

    });

    // 3. Where we tell Grunt we plan to use this plug-in.
    require('load-grunt-tasks')(grunt);

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', ['watch']);

};
