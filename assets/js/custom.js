(function ($) {

    class AppMenu {
        init() {
            this.appToggleMenu();
        }
        appToggleMenu() {
            $('.app-toggle-menu').on('click', function (e) {
                e.preventDefault();
                $('.app-side-menu').toggleClass('show');
            });
            $('.side-menu-close').on('click', function (e) {
                e.preventDefault();
                $(this).parents('.app-side-menu').toggleClass('show');
            });
        }
    }

    $(document).ready(function () {
        var appmenu = new AppMenu();
        appmenu.init();

    });
})(jQuery);