
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


$('input[name=title]').on('blur', function () {
    var slugElement = $('input[name=slug]');

    if (slugElement.val()) {
        return;
    }

    slugElement.val(this.value.toLowerCase().replace(/[^a-z0-9-]+/g, '-').replace(/^-+|-+$/g, ''));
});