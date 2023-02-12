jQuery(document).ready(function () {
    let $wrapper = $('.mp-warper');
    $wrapper.on('click', '.mp-remove', function (e) {
        e.preventDefault();

        $(this).closest('.mp-item')
            .fadeOut()
            .remove();
    });
    $('.mp-add').on('click', function (e) {
        e.preventDefault();

        let prototype = $wrapper.data('prototype');
        let index = $wrapper.data('index');
        let newForm = prototype.replace(/__name__/g, index);
        $wrapper.data('index', index + 1);
        $wrapper.append(newForm);
    });
});
