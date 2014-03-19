'use strict';
module.exports = function(grunt) {

    // load all grunt tasks
    require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

    grunt.initConfig({

        // watch for changes and trigger compass, jshint, uglify and livereload
        watch: {
            options: {
                livereload: true,
            },
            compass: {
                files: ['sass/**/*.{scss,sass}', 'config.rb'],
                tasks: ['compass']
            },
            js: {
                files: ['js/**/*.js'],
                tasks: ['uglify']
            },
            livereload: {
                files: ['*.html', '*.php', 'img/**/*.{png,jpg,jpeg,gif,webp,svg}']
            }
        },

        // compass and scss
        compass: {
            dist: {
                options: {
                    config: 'config.rb',
                    force: true
                }
            }
        },

        // uglify to concat, minify, and make source maps
        uglify: {
            dist: {
                options: {
                    sourceMap: 'js/generated/source-map.js'
                },
                files: {
                    'js/generated/scripts.min.js': [
                        'js/vendor/**/*.js',
                        '!js/vendor/modernizr.2.7.min.js',
                        'js/scripts.js'
                    ]
                }
            }
        }

    });

    // register task
    grunt.registerTask('default', ['watch']);

};