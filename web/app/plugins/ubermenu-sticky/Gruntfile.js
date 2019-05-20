module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    'closure-compiler': {
      frontend: {
        closurePath: '/usr/local/lib/closure-compiler',
        js: 'assets/*.js',
        jsOutputFile: 'assets/ubermenu.sticky.min.js',
        maxBuffer: 500,
        options: {
          compilation_level: 'SIMPLE_OPTIMIZATIONS',
          language_in: 'ECMASCRIPT5_STRICT'
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-closure-compiler');

  grunt.registerTask('default', ['closure-compiler']);

};