requirejs.config({
    shim: {
        backbone: {
            deps: ['jquery', 'underscore', 'json2'],
            exports: 'Backbone'
        },
        underscore: {
            exports: '_'
        },
        jquery: {
            exports: 'jQuery'
        },
        Handlebars: {
            exports: 'Handlebars'
        },
        json2: {
            exports: 'JSON'
        }
    },
    hbs: {
        disableI18n: true
    },
    paths: {
        jquery: 'vendor/jquery-1.9.1.min',
        underscore: 'vendor/underscore',
        json2: 'vendor/json2',
        backbone: 'vendor/backbone',
        handlebars: 'vendor/handlebars',
        hbs: 'vendor/hbs',
        hbs_i18nprecompile: 'vendor/hbs_i18nprecompile',
        Handlebars: 'vendor/handlebars'
    }
});