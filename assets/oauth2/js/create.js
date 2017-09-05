/*
*   Äkwav Coflnet
*
*/
$(document).ready(function() {

    $("#client-table-box").ufTable({
        dataUrl: site.uri.public + "/api/clients",
        useLoadingTransition: site.uf_table.use_loading_transition
    });
    console.log("kevin");
    $(".js-client-create").click(function() {
        $("body").ufModal({
            sourceUrl: site.uri.public + "/modals/client/create",
            msgTarget: $("#alerts-page")
        });
        attachSubmitForm();
    });
});


function attachSubmitForm() {
    $("body").on('renderSuccess.ufModal', function (data) {
        var modal = $(this).ufModal('getModal');
        var form = modal.find('.js-form');
        // Set up the form for submission
        form.ufForm({
            validators: page.validators
        }).on("submitSuccess.ufForm", function() {
            // Reload page on success
            window.location.reload();
        });
    });
}
