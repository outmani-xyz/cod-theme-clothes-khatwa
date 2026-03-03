/**
 * khutwa Main Scripts (Final Reliability Fix)
 * Ensures swatches work even with AJAX and various WC versions
 */
(function ($) {
    'use strict';

    $(function () {
        console.log('khutwa Final JS: Activated');

        console.log('khutwa Final JS: Activated');

        // Note: Cart click deliberately excluded so it goes straight to /cart/

        // Click Handler for Variation Swatches
        // Using delegaton on document to be extremeley safe
        $(document).on('click', '.swatch-btn', function (e) {
            e.preventDefault();
            const $btn = $(this);
            const $container = $btn.closest('.custom-swatches');
            const attrName = $container.data('attribute_name');
            const value = $btn.data('value');
            const $form = $btn.closest('form.variations_form');

            console.log('khutwa: Clicked swatch value=' + value + ' for attr=' + attrName);

            const $select = $form.find('select[name="' + attrName + '"]');
            if ($select.length) {
                // Update select
                $select.val(value).trigger('change');

                // Visual Feedback
                $container.find('.swatch-btn').removeClass('active btn-dark').addClass('btn-outline-dark');
                $btn.removeClass('btn-outline-dark').addClass('active btn-dark');

                // Trigger form update
                $form.trigger('check_variations');

                console.log('khutwa: Updated select and triggered check_variations');
            } else {
                console.error('khutwa: Could not find select name=' + attrName);
            }
        });

    });

})(jQuery);
