module.exports = function (grunt) {
  grunt.registerTask('replace_package_json', function () {
    var path = grunt.config.process('<%= build %>/package.json');
    var pkg = grunt.config.get('pkg');

    grunt.file.write(path, JSON.stringify({
      name: pkg.name,
      description: pkg.description,
      keywords: pkg.keywords,
      version: pkg.version,
      build: {
        number: grunt.config.get('buildNum'),
        sha: grunt.config.get('commitSha')
      },
      repository: pkg.repository,
      dependencies: pkg.dependencies
    }, null, '  '));
  });
};
