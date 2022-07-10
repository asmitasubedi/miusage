This is the Miusage plugin. It retrieves data from a remote API endpoint, and displays via a shortcode and on an admin WordPress page.

## Requirements

Make sure all dependencies have been installed before moving on:

* [PHP](http://php.net/manual/en/install.php) >= 7.2
* [Composer](https://getcomposer.org/download/)
* [Node.js](http://nodejs.org/) >= 14.x
* [Yarn](https://yarnpkg.com/en/docs/install)

## Plugin development

Miusage uses [Webpack](https://webpack.github.io/) as a build tool and [npm](https://www.npmjs.com/) to manage front-end packages.

### Install dependencies

From the command line on your host machine, navigate to the plugin directory then run `composer install`:

```shell
# @ example.com/site/web/app/plugins/your-plugin-name
$ composer install
```

Then run `yarn install`:

```shell
# @ example.com/site/web/app/plugins/your-plugin-name
$ yarn install
```

You now have all the necessary dependencies to run the build process.

### Build commands

* `yarn start` — Compile assets when file changes are made, start Browsersync session
* `yarn build` — Compile and optimize the files in your assets directory

## Documentation

### Shortcode

    [miusage_challenges]

    [miusage_challenges show_title=true show_id=true show_fname=false show_lname=true show_email=false show_date=true]

### Admin page

    Miusage

### API

    /miusage/v1/challenges

### WP-CLI

    wp miusage challenges refresh

### Blocks

    miusage/challenges
