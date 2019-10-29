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
        './vendor/bower_components/sweetalert2/dist/sweetalert2.min.css',
        './vendor/bower_components/gentelella/vendors/pnotify/dist/pnotify.css',
        './vendor/bower_components/gentelella/vendors/pnotify/dist/pnotify.buttons.css',
        './vendor/bower_components/gentelella/vendors/pnotify/dist/pnotify.nonblock.css',
        './vendor/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
        './vendor/bower_components/datatables.net-buttons-bs/css/buttons.bootstrap.css',
        './vendor/bower_components/gentelella/vendors/select2/dist/css/select2.min.css',
        'custom.css'
    ], 'public/css/gentelella.min.css');


    // Receipts
    mix.styles([
        'receipt.css'
    ], 'public/css/receipt.min.css');


    // PDF Receipts
    mix.styles([
        'receipt-pdf.css'
    ], 'public/css/receipt-pdf.min.css');

    // Business - Company
    mix.styles([
        './vendor/bower_components/bootstrap-fileinput/css/fileinput.min.css'

    ], 'public/css/company.min.css');
    /****************/
    /*     Merge    */
    /****************/

    // Scripts Básicos
    mix.scripts([
        './vendor/bower_components/pdfmake/build/pdfmake.min.js',
        './vendor/bower_components/pdfmake/build/vfs_fonts.js',
        './vendor/bower_components/gentelella/vendors/jquery/dist/jquery.min.js', // JQUERy
        './vendor/bower_components/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js', //bootstrap
        './vendor/bower_components/gentelella/vendors/nprogress/nprogress.js', //NProgress
        './vendor/bower_components/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js', //Bootstrap Progressbar
        './vendor/bower_components/gentelella/vendors/fastclick/lib/fastclick.js', //Fastclick
        './vendor/bower_components/sweetalert2/dist/sweetalert2.min.js', //Sweetalert2
        './vendor/bower_components/gasparesganga-jquery-loading-overlay/src/loadingoverlay.js', // Loading Overlay
        './vendor/bower_components/js-cookie/src/js.cookie.js', //Cookies
        './vendor/bower_components/gentelella/vendors/pnotify/dist/pnotify.js', // Pnotify
        './vendor/bower_components/gentelella/vendors/pnotify/dist/pnotify.buttons.js', //Pnotify
        './vendor/bower_components/gentelella/vendors/pnotify/dist/pnotify.nonblock.js', // Pnotify
        './vendor/bower_components/datatables.net/js/jquery.dataTables.js', // Datatables
        './vendor/bower_components/datatables.net-bs/js/dataTables.bootstrap.js', // Datatables
        './vendor/bower_components/datatables.net-buttons/js/dataTables.buttons.js', // Datatables
        './vendor/bower_components/datatables.net-buttons/js/buttons.print.js', // Datatables
        './vendor/bower_components/datatables.net-buttons/js/buttons.html5.js', // Datatables
        './vendor/bower_components/datatables.net-buttons/js/buttons.colVis.js', // Datatables
        './vendor/bower_components/datatables.net-buttons-bs/js/buttons.bootstrap.min.js', // Datatables
        './vendor/bower_components/jszip/dist/jszip.min.js',
        './vendor/bower_components/gentelella/vendors/parsleyjs/dist/parsley.min.js',
        './vendor/bower_components/gentelella/vendors/parsleyjs/dist/i18n/pt-br.js',
        './vendor/bower_components/jquery-mask-plugin/dist/jquery.mask.js',
        './vendor/bower_components/gentelella/vendors/select2/dist/js/select2.full.min.js',
        'jquery.maskMoney.js',

        'mask.js',
        'select2.js',
        'seara.js',
        'notify.js',
        'gentelella/helpers/smartresize.js',
        'gentelella/custom.js',
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
        './vendor/bower_components/bootstrap-fileinput/js/fileinput.js',
        './vendor/bower_components/bootstrap-fileinput/js/locales/pt-BR.js',
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

    // Máscaras
    mix.scripts([
        './vendor/bower_components/jquery-mask-plugin/dist/jquery.mask.js',
        'jquery.maskMoney.js',
        'mask.js'
    ], 'public/js/mask.min.js');

    // Receipts
    mix.scripts([
        './vendor/bower_components/gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js',
        './vendor/bower_components/gentelella/vendors/parsleyjs/dist/parsley.min.js',
        'helpers.js',
        'receipt.js'
    ], 'public/js/receipt.min.js');

    // Usuários
    mix.scripts([
        './vendor/bower_components/gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js',
        './vendor/bower_components/gentelella/vendors/parsleyjs/dist/parsley.min.js',
        './vendor/bower_components/jquery-mask-plugin/dist/jquery.mask.js',
        'mask.js',
        'helpers.js',
        'users.js'
    ], 'public/js/users.min.js');

    mix.scripts([
        './vendor/bower_components/gentelella/vendors/jquery-ui/jquery-ui.min.js',
        './vendor/bower_components/gentelella/vendors/iCheck/icheck.min.js',
        'home.js'
    ], 'public/js/home.min.js');

    // Customers
    mix.scripts([
        'helpers.js',
        'customer/customer.js',
    ], 'public/js/customer.min.js');

    // Financing > accounts
    mix.scripts([
        'helpers.js',
        'financing/account.js'
    ], 'public/js/financing/account.min.js');

    // Financing > income category
    mix.scripts([
        'helpers.js',
        'crud.js',
        'financing/income_category.js'
    ], 'public/js/financing/income_category.min.js');
    mix.version('public/js/financing/income_category.min.js');

    // Financing > receivable
    mix.scripts([
        'helpers.js',
        'crud.js',
        'financing/receivable.js'
    ], 'public/js/financing/receivable.min.js');
    mix.version('public/js/financing/receivable.min.js');

    /**************/
    /* Copy Fonts */
    /**************/

    /* -  ARQUIVOS DE PLUGINS E BIBLIOTECAS  -  */
    //ARQUIVOS PARA HOME
    mix.styles([
        './vendor/bower_components/gentelella/vendors/jquery-ui/jquery-ui.min.css',
        './vendor/bower_components/gentelella/vendors/jquery-ui/jquery-ui.theme.css'
    ], 'public/css/home.min.css');


    // Bootstrap
    mix.copy('vendor/bower_components/gentelella/vendors/bootstrap/fonts/', 'public/fonts');

    // Font awesome
    mix.copy('vendor/bower_components/gentelella/vendors/font-awesome/fonts/', 'public/fonts');

    // Imagens
    mix.copy('resources/assets/img/', 'public/img/');
});
