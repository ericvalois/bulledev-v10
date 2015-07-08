module.exports = function(grunt) {
    grunt.initConfig({
        // running `grunt less` will compile once
        sass: {
            dist: {
                options: {
                  // cssmin will minify later
                  style: 'compressed',
                  sourcemap: 'none',
                  noCache: true
                },
                files: {
                  'style.css': 'sass/style.scss',
                }
            }
        },

        criticalcss: {
            archive: {
                options: {
                    url: "http://bulledev.dev/",
                    width: 1200,
                    height: 900,
                    outputfile: "critical/archive.css",
                    filename: "style.css", // Using path.resolve( path.join( ... ) ) is a good idea here
                    buffer: 800*1024,
                    ignoreConsole: false
                }
            },
            page: {
                options: {
                    url: "http://bulledev.dev/a-propos/",
                    width: 1200,
                    height: 900,
                    outputfile: "critical/page.css",
                    filename: "style.css", // Using path.resolve( path.join( ... ) ) is a good idea here
                    buffer: 800*1024,
                    ignoreConsole: false
                }
            },
            single: {
                options: {
                    url: "http://bulledev.dev/resume-performance-web-fevrier-2015/",
                    width: 1200,
                    height: 900,
                    outputfile: "critical/single.css",
                    filename: "style.css", // Using path.resolve( path.join( ... ) ) is a good idea here
                    buffer: 800*1024,
                    ignoreConsole: false
                }
            }
        },

        cssmin: {
          target: {
            files: [{
              expand: true,
              cwd: 'critical',
              src: ['*.css', '!*.min.css'],
              dest: 'critical',
              ext: '.min.css'
            }]
          }
        },
        // running `grunt watch` will watch for changes
        watch: {
            sass: {
                files: ['sass/*.scss'],
                tasks: ["sass"]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-criticalcss');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    grunt.registerTask('critical', ['criticalcss', 'cssmin']);

};