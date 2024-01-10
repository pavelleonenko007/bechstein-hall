window.addEventListener('load', () => {
    document.body.addEventListener('click', event => {
        const addButton = event.target.closest('[data-button="add-links"]');
        const bechRepeaterFieldsNodesLength = document.querySelectorAll('.bech-repeater-fields').length - 1;

        if (!addButton) return;

        addButton.insertAdjacentHTML('beforebegin', `<div class="bech-repeater-fields">
                    <label>
                        Title
                        <input type="text" class="widefat" name="widget-bech_repeater_links_widget[2][links][${bechRepeaterFieldsNodesLength}][title]" value=""> 
                    </label>
                    <label>
                        Description
                        <input type="text" class="widefat" name="widget-bech_repeater_links_widget[2][links][${bechRepeaterFieldsNodesLength}][description]"" value="">
                    </label>
                    <label>
                        URL
                        <input type="text" class="widefat" name="widget-bech_repeater_links_widget[2][links][${bechRepeaterFieldsNodesLength}][url]"" value="">
                    </label>
                </div>`)
    })
});