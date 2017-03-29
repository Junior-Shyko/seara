var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

// Gentelella vendors path : vendor/bower_components/gentelella/vendors

elixir(function(mix) {

    /********************/
    /* Merge Stylesheets*/
    /********************/
    mix.styles([
      './vendor/bower_components/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css',
      './vendor/bower_components/gentelella/vendors/font-awesome/css/font-awesome.min.css',
      './vendor/bower_components/gentelella/build/css/custom.min.css'
    ], 'public/css/gentelella.min.css');

    /****************/
    /*     Merge    */
    /****************/

    // Scripts Básicos
    mix.scripts([
      './vendor/bower_components/gentelella/vendors/jquery/dist/jquery.min.js',
      './vendor/bower_components/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js',
      'gentelella/helpers/smartresize.js',
      'gentelella/custom.js'
    ], 'public/js/gentelella.min.js');

    // Registro
    mix.scripts([
      './vendor/bower_components/gentelella/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js',
      './vendor/bower_components/gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js',
      'register.js'
    ], 'public/js/register.min.js');

    /**************/
    /* Copy Fonts */
    /**************/

    // Bootstrap
    mix.copy('vendor/bower_components/gentelella/vendors/bootstrap/fonts/', 'public/fonts');

    // Font awesome
    mix.copy('vendor/bower_components/gentelella/vendors/font-awesome/fonts/', 'public/fonts');
});
