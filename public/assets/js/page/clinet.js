function fnAddPersonrow() {
    $("div[id^='divClientPerson']:last").after($('#divClientPerson').clone().find(":hidden#PersonId").val(0).end().find("input#p_Telephone").val("").end().find("input#p_Mobile").val("").end().find(":text").val("").end().find(":button").removeAttr("disabled").end());
}
function fnDeletePersonrow(PersonID, button) {
    
    var rowidx = $(button).closest('.row').data('value');
    var ApiUrl = $("#hdnApiUrl").val();

    if (rowidx == 1) {
        $("#p_PersonFirstName").val("");
        $("#p_PersonLastName").val("");
        $("#p_Email").val("");
        $("#p_Telephone").val("");
        $("#p_Mobile").val("");
    }
    else {
        $(button).closest('.row').remove();
    }
    if (PersonID != '') {
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: ApiUrl + 'api/Person/DeletePerson/',
            data: { pId: PersonID },
            success: function (data) {
            }
        });
    }
}
function fnCopyInvoiceAddress() {
    $("#InvoiceAddress").val($("#Address").val());
    $("#InvoiceCity").val($("#City").val());
    $("#InvoicePlace").val($("#Place").val());
    $("#InvoiceZipCode").val($("#ZipCode").val());
    $("#ddlInvoiceState").val($("#ddlState").val()).change();
    $("#ddlInvoiceCountry").val($("#ddlCountry").val()).change();
}
function fnSaveClient() {
    var ClientName = $.trim($("#ClientName").val());
    var hdnclientName = $("#hdnClientName").val();

    var ApiUrl = $("#hdnApiUrl").val();
    var IsClientEdit = $("#hdnIsClientEdit").val();

    if (ClientName != '') {
        var PersonId = $("input[id='PersonId']")
            .map(function () { return $(this).val(); }).get();
        var PersonFirstName = $("input[id='p_PersonFirstName']")
            .map(function () { return $(this).val(); }).get();
        var PersonLastName = $("input[id='p_PersonLastName']")
            .map(function () { return $(this).val(); }).get();
        var PersonEmail = $("input[id='p_Email']")
            .map(function () { return $(this).val(); }).get();
        var Mobile = $("input[id='p_Mobile']")
            .map(function () { return $(this).val(); }).get();
        var Telephone = $("input[id='p_Telephone']")
            .map(function () { return $(this).val(); }).get();
        var Salutation = $("select[id='ddlClientSalutation']")
            .map(function () { return $(this).val(); }).get();

        $.ajax({
            type: "POST",
            url: '/Client/SetClientPersonData',
            data: { PersonIds: PersonId, PersonFirstNames: PersonFirstName, PersonLastNames: PersonLastName, PersonEmails: PersonEmail, Mobiles: Mobile, Telephones: Telephone, Salutations: Salutation },
            success: function (r) {

                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    url: ApiUrl + 'api/Client/CheckClientNameExists/',
                    data: { CtName: ClientName },
                    success: function (data) {
                        if (data == false || ClientName == hdnclientName) {
                            $("#frmcreateclient").submit();
                        }
                        else {
                            $("#ClientName").focus();
                            iziToast.error({
                                title: 'Kunde',
                                message: 'Clinet Name Already Exists, Please choose different Name',
                                position: 'topRight'
                            });
                        }
                    }
                });
            }
        });
    }
    else {
        $("#ClientName").focus();
        iziToast.error({
            title: 'Kunde',
            message: 'Clinet Name Cannot be Empty',
            position: 'topRight'
        });
    }
}
