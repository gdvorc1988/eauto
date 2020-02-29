$(document).ready(function () {
    $(".js-page-limit-dropdown").on("click", function () {
        $(this)
            .parent()
            .toggleClass("limit-dropdown-visible");
    })
})