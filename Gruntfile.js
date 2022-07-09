module.exports = function( grunt ) {

	'use strict';

	// Project configuration
	grunt.initConfig( {

		pkg: grunt.file.readJSON( 'package.json' ),

		options: {
			text_domain: "miusage",
		},

		addtextdomain: {
			options: {
				textdomain: '<%= options.text_domain %>',
			},
			update_all_domains: {
				options: {
					updateDomains: true
				},
				src: [ '*.php', '**/*.php', '!\.git/**/*', '!bin/**/*', '!node_modules/**/*', '!tests/**/*' ]
			}
		},

		checktextdomain: {
			options: {
				text_domain: "<%= options.text_domain %>",
				keywords: [
					"__:1,2d",
					"_e:1,2d",
					"_x:1,2c,3d",
					"esc_html__:1,2d",
					"esc_html_e:1,2d",
					"esc_html_x:1,2c,3d",
					"esc_attr__:1,2d",
					"esc_attr_e:1,2d",
					"esc_attr_x:1,2c,3d",
					"_ex:1,2c,3d",
					"_n:1,2,4d",
					"_nx:1,2,4c,5d",
					"_n_noop:1,2,3d",
					"_nx_noop:1,2,3c,4d",
				],
			},
			files: {
				src: [
					"**/*.php",
					"!.git/**",
					"!node_modules/**",
					"!vendor/**",
					"!tests/**",
					"!assets/**",
					"!deploy/**",
					"!build/**",
					"!dist/**",
					"!release/**",
				],
				expand: true,
			},
		},

		wp_readme_to_markdown: {
			your_target: {
				files: {
					'README.md': 'readme.txt'
				}
			},
		},

		makepot: {
			target: {
				options: {
					domainPath: '/languages',
					exclude: [ '\.git/*', 'bin/*', 'vendor/*', 'node_modules/*', 'tests/*', 'build/*' ],
					mainFile: 'miusage.php',
					potFilename: '<%= pkg.name %>.pot',
					potHeaders: {
						"report-msgid-bugs-to": "",
						"x-poedit-keywordslist": true,
						"language-team": "",
						Language: "en_US",
						"X-Poedit-SearchPath-0": "../../<%= pkg.name %>",
						"plural-forms": "nplurals=2; plural=(n != 1);",
						"Last-Translator": "Asmita",
					},
					type: 'wp-plugin',
					updateTimestamp: true
				}
			}
		},

		exec: {
			makepot: {
				cmd: "wp i18n make-pot ./ languages/miusage.pot --ignore-domain",
			},
			makejson: {
				cmd: "wp i18n make-json languages/ --no-purge",
			},
			production: {
				cmd: "yarn build",
			},
		},
	} );

	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks("grunt-checktextdomain");
	grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );
	grunt.registerTask( 'default', [ 'i18n','readme' ] );
	grunt.registerTask( 'i18n', ['addtextdomain', 'makepot'] );
	grunt.registerTask( 'readme', ['wp_readme_to_markdown'] );
	grunt.loadNpmTasks("grunt-exec");

	grunt.util.linefeed = '\n';

	grunt.registerTask("buildit", [
		"i18n",
		"exec:production",
		"exec:makepot",
		"exec:makejson",
	]);

};
