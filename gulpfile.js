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
      'custom.css'
    ], 'public/css/gentelella.min.css');


    // Receipts
    mix.styles([
      './vendor/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
      'receipt.css'
    ], 'public/css/receipt.min.css');


    // PDF Receipts
    mix.styles([
      'cssbase-min.css',
      'cssreset-min.css',
      'receipt-pdf.css'
    ], 'public/css/receipt-pdf.min.css');

    // Notifications
    mix.styles([
      './vendor/bower_components/gentelella/vendors/pnotify/dist/pnotify.css',
      './vendor/bower_components/gentelella/vendors/pnotify/dist/pnotify.buttons.css',
      './vendor/bower_components/gentelella/vendors/pnotify/dist/pnotify.nonblock.css',
    ], 'public/css/notify.min.css');


    // Business - Company
    mix.styles([
      './vendor/bower_components/bootstrap-fileinput/css/fileinput.min.css'
     
    ], 'public/css/company.min.css');
    /****************/
    /*     Merge    */
    /****************/

    // Scripts Básicos
    mix.scripts([
      './vendor/bower_components/gentelella/vendors/jquery/dist/jquery.min.js', // JQUERy
      './vendor/bower_components/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js', //bootstrap
      './vendor/bower_components/gentelella/vendors/nprogress/nprogress.js', //NProgress
      './vendor/bower_components/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js', //Bootstrap Progressbar
      './vendor/bower_components/gentelella/vendors/fastclick/lib/fastclick.js', //Fastclick
      'gentelella/helpers/smartresize.js',
      'gentelella/custom.js'
    ], 'public/js/gentelella.min.js');

    // Registro
    mix.scripts([
      './vendor/bower_components/gentelella/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js',
      './vendor/bower_components/gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js',
      './vendor/bower_components/gentelella/vendors/parsleyjs/dist/parsley.min.js',
      'register/validator_conf.js',
      'register/mask_autocomplete_conf.js',
      'spin.js',
      'register/register.js'
    ], 'public/js/register.min.js');

    //Business - Company
    mix.scripts([
      './vendor/bower_components/gentelella/vendors/bootstrap-fileinput/js/fileinput.js',
      './vendor/bower_components/gentelella/vendors/bootstrap-fileinput/js/locales/pt-BR.js',
      'company.js'
    ],'public/js/company.min.js');
    
    // Auth views
    mix.scripts([
      './vendor/bower_components/gentelella/vendors/parsleyjs/dist/parsley.min.js',
    ], 'public/js/parsley.min.js');

    // editar
    mix.scripts([
      './vendor/bower_components/gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js',
      './vendor/bower_components/gentelella/vendors/parsleyjs/dist/parsley.min.js',
      'register/validator_conf.js',
      'register/mask_autocomplete_conf.js',
    ], 'public/js/mask_camp.min.js');


    // Notificação
    mix.scripts([
      './vendor/bower_components/gentelella/vendors/pnotify/dist/pnotify.js',
      './vendor/bower_components/gentelella/vendors/pnotify/dist/pnotify.buttons.js',
      './vendor/bower_components/gentelella/vendors/pnotify/dist/pnotify.nonblock.js',
      'notify.js'
    ], 'public/js/notify.min.js');

    // Máscaras
    mix.scripts([
      './vendor/bower_components/jquery-mask-plugin/dist/jquery.mask.js',
      'mask.js'
    ], 'public/js/mask.min.js');

    // Receipts
    mix.scripts([
      './vendor/bower_components/datatables.net/js/jquery.dataTables.js',
      './vendor/bower_components/datatables.net-bs/js/dataTables.bootstrap.js',
      './vendor/bower_components/gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js',
      './vendor/bower_components/gentelella/vendors/parsleyjs/dist/parsley.min.js',
      'helpers.js',
      'receipt.js'
    ], 'public/js/receipt.min.js');

    mix.scripts([
      './vendor/bower_components/js-cookie/src/js.cookie.js',
      'seara.js'
    ], 'public/js/seara.min.js');

    
    // Usuários
    mix.scripts([
      './vendor/bower_components/datatables.net/js/jquery.dataTables.js',
      './vendor/bower_components/datatables.net-bs/js/dataTables.bootstrap.js',
      './vendor/bower_components/gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js',
      './vendor/bower_components/gentelella/vendors/parsleyjs/dist/parsley.min.js',
      './vendor/bower_components/jquery-mask-plugin/dist/jquery.mask.js',
      './vendor/bower_components/js-cookie/src/js.cookie.js',
      './vendor/bower_components/gentelella/vendors/pnotify/dist/pnotify.js',
      './vendor/bower_components/gentelella/vendors/pnotify/dist/pnotify.buttons.js',
      './vendor/bower_components/gentelella/vendors/pnotify/dist/pnotify.nonblock.js',
      './vendor/bower_components/gasparesganga-jquery-loading-overlay/src/loadingoverlay.js',
      'mask.js',
      'helpers.js',
      'searaTable.js',
      'seara.js',
      'notify.js',
      'users.js'
    ], 'public/js/users.min.js');

    /**************/
    /* Copy Fonts */
    /**************/

    /* -  ARQUIVOS DE PLUGINS E BIBLIOTECAS  -  */
    //ARQUIVOS PARA HOME
    mix.styles([
      './vendor/bower_components/gentelella/vendors/jquery-ui/jquery-ui.min.css',
      './vendor/bower_components/gentelella/vendors/jquery-ui/jquery-ui.theme.css'      
    ], 'public/css/home.min.css');

    mix.scripts([
      './vendor/bower_components/gentelella/vendors/jquery-ui/jquery-ui.min.js',
      'plugins/fastclick.js',
      'plugins/nprogress.js',
      'plugins/icheck.js',
      'home.js' 
    ], 'public/js/home.min.js');


    // Bootstrap
    mix.copy('vendor/bower_components/gentelella/vendors/bootstrap/fonts/', 'public/fonts');

    // Font awesome
    mix.copy('vendor/bower_components/gentelella/vendors/font-awesome/fonts/', 'public/fonts');
});
