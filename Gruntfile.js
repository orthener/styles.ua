module.exports = function(grunt) {
    grunt.initConfig({
        less: {
            development: {
                options: {
                    paths: ["./app/webroot/css/less/"],
                    compress: false,
                    dumpLineNumbers: "all"
                },
                files: {
                    "./app/webroot/css/default.css": "./app/webroot/css/less/default.less"
                }
            }
        },
        watch: {
            lesss: {
                files: ["./app/webroot/css/less/*"],
                tasks: ["less"]
            },
        }
    });
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');
};