$(function () {
    $("#ddlProjectClient").change(function () {
        var ApiUrl = $("#hdnApiUrl").val();
        var clientID = $("#ddlProjectClient").val();
        if (!isNaN(clientID)) {
            $('#Address').val("");
            $('#Place').val("");
            $('#ZipCode').val("");

            $.ajax({
                url: ApiUrl + 'api/Project/GetClientData',
                type: "GET",
                dataType: 'json',
                data: { 'ClientId': clientID },
                success: function (data) {
                    //alert(data);
                    $.each(data, function (i, char) {
                        $('#Address').val(char.address);
                        $('#Place').val(char.place);
                        $('#ZipCode').val(char.zipCode);
                        $('#ddlState').val(char.stateId).change();
                        $('#ddlland').val(char.landId).change();
                    });
                    //console.log(data);
                },
                failure: function (data) {
                    alert(data.Error);
                },
                error: function (data) {
                    alert(data.Error);
                }

            });
        }
    });

    $("#ddlCategory").change(function () {
        var ApiUrl = $("#hdnApiUrl").val();
        var CategoryId = $("#ddlCategory").val();
        if (!isNaN(CategoryId)) {
            $.ajax({
                url: ApiUrl + 'api/Project/GetProjectNumber',
                type: "GET",
                dataType: 'json',
                data: { 'categoryId': CategoryId },
                success: function (data) {
                    //alert(data);
                    $("#Number").val(data)
                },
                failure: function (data) {
                    alert(data.responseText);
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });
        }
    });

    $("#closbtn").click(function () {
        $('#myModal').modal('hide');
    });
});

$(document).ready(function () {
    CKEDITOR.replace('#ProjectOfferDocument');
    var ApiUrl = $("#hdnApiUrl").val();
    var hdnProjectName = $("#hdnProjectName").val();
    var hdnBuilder = $("#hdnBuilder").val();
    var hdnArichtech = $("#hdnArichtech").val();
    var hdnProjectNumber = $("#hdnProjectNumber").val();
    var hdnFileNumber = $("#hdnFileNumber").val();
    var hdnProjectDocumentID = $("#hdnProjectDocumentID").val();

    if (hdnProjectDocumentID > 0) {
        $.ajax({
            url: ApiUrl + 'api/Project/GetProjectDocumentData',
            type: "GET",
            dataType: 'json',
            data: {
                'DocumentId': hdnProjectDocumentID,
                'DocumentType': 'Offer',
            },
            success: function (data) {
                //alert(data);
                CKEDITOR.instances['ProjectOfferDocument'].setData(data);
            },
            failure: function (data) {
                alert(data.responseText);
            },
            error: function (data) {
                alert(data.responseText);
            }
        });
    }

    else if (hdnProjectName != undefined) {
        $.get('http://localhost:5168/Template/wordtemplates/Angebot_BSK-3.html')
            .done(response => { CKEDITOR.instances['ProjectOfferDocument'].setData(response.replace('_ProjectName', hdnProjectName).replace('_Builder', hdnBuilder).replace('_Arichtech', hdnArichtech).replace('_ProjectNumber', hdnProjectNumber).replace('_FileNumber', hdnFileNumber)); })
            .fail(/** process error here **/);
    }
});

function fnSaveOfferDocument() {
    var ProjectDocumentData = CKEDITOR.instances['ProjectOfferDocument'].getData();
    var hdnProjectNumber = $("#hdnProjectNumber").val();
    var hdnProjectDocumentID = $("#hdnProjectDocumentID").val();

    $.ajax({
        type: 'POST',
        url: '/Project/InsertUpdateProjectDocument',
        dataType: 'json',
        data: {
            ProjectId: hdnProjectNumber,
            ProjectDocumentId: hdnProjectDocumentID,
            ProjectDocumentName: hdnProjectNumber + 'OfferDocument',
            ProjectDocumentType: 'Offer',
            ProjectDocumentData: ProjectDocumentData,
        },
        success: function (data) {
            $("#hdnProjectDocumentID").val(data);
            iziToast.success({
                title: 'Project Offer Document',
                message: 'Your changes have been successfully saved !',
                position: 'topRight'
            });
        },
        failure: function (data) {
            alert(data.responseText);
        },
        error: function () {
        }
    });

}
var TeamDetailPostBackURL = '/AddProjectClient';
function fnAddClient() {
    var options = { "backdrop": "static", keyboard: true };
    $.ajax({
        type: "GET",
        url: TeamDetailPostBackURL,
        contentType: "application/json; charset=utf-8",
        datatype: "json",
        success: function (data) {
            $('#mdl_ProjectClient').html(data);
            $('#myModal').modal(options);
            $('#myModal').modal('show');
        },
        error: function () {
            alert("Dynamic content load failed.");
        }
    });
}
function fnCopyProjectClientInvoiceAddress() {
    $("#InvoiceClientAddress").val($("#ClientAddress").val());
    $("#InvoiceClinetCity").val($("#ClientCity").val());
    $("#InvoiceClinetPlace").val($("#ClinetPlace").val());
    $("#InvoiceClientZipCode").val($("#ClientZipCode").val());
    $("#ddlInvoiceClientState").val($("#ddlClientState").val()).change();;
    $("#ddlInvoiceClientCountry").val($("#ddlClientCountry").val()).change();;
}

function fnSaveProjectClient() {
    var ClientName = $.trim($("#ClientName").val());
    var ApiUrl = $("#hdnApiUrl").val();
    var selectedValue = ClientName;

    var model = {
        ClientName: ClientName,
        CustomerTypeId: $('input[name="CustomerTypeId"]:checked').val(),
        CustomersTypeId: $("#ddlMulCustomerType").val(),
        Telphone: $("#Telphone").val(),
        Fax: $("#Fax").val(),
        Mobile: $("#Mobile").val(),
        Internet: $("#Internet").val(),
        BillingEmail: $("#BillingEmail").val(),
        Email: $("#Email").val(),
        Memo: $("#Memo").val(),
        Notes: $("#Notes").val(),
        Address: $("#ClientAddress").val(),
        InvoiceAddress: $("#InvoiceClientAddress").val(),
        City: $("#ClientCity").val(),
        InvoiceCity: $("#InvoiceClinetCity").val(),
        Place: $("#ClinetPlace").val(),
        InvoicePlace: $("#InvoiceClinetPlace").val(),
        ZipCode: $("#ClientZipCode").val(),
        StateId: $("#ddlClientState").val(),
        InvoiceStateId: $("#ddlInvoiceClientState").val(),
        CountryId: $("#ddlClientCountry").val(),
        InvoiceCountryId: $("#ddlInvoiceClientCountry").val()
    }

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
                        if (data == false) {
                            $.ajax({
                                type: 'POST',
                                url: '/Project/InsertUpdateProjectClient',
                                dataType: 'json',
                                data: { Client_Model: model },
                                success: function (data) {
                                    $('#myModal').modal('hide');

                                    $.ajax({
                                        type: "GET",
                                        url: ApiUrl + 'api/Project/GetClientJsonList',
                                        data: {},
                                        dataType: "json",
                                        success: function (data) {
                                            $("#ddlProjectClient").empty();
                                            $.each(data, function (i, char) {
                                                $("#ddlProjectClient").append($("<option     />").val(char.id).text(char.clientName));
                                            });

                                            $('#ddlProjectClient option').map(function () {
                                                if ($(this).text() == selectedValue) return this;
                                            }).attr('selected', 'selected');

                                            $('#ddlProjectClient').trigger('change');
                                        }
                                    });
                                },
                                failure: function (data) {
                                    alert(data.responseText);
                                },
                                error: function () {
                                    console.log('something went wrong - debug it!');
                                }
                            });
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