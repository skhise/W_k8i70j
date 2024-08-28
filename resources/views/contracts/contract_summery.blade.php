<x-app-layout>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Contract Summery</h4>
                            </div>
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>

    @section('script')
        <script>
            $(document).on('change', '#CNRT_Charges', function() {
                var total = $(this).val();
                var paid = $("#CNRT_Charges_Paid").val();
                var pending = total - paid;
                $("#CNRT_Charges_Pending").val(pending);
            });
            $(document).on('change', '#CNRT_Charges_Paid', function() {
                var total = $("#CNRT_Charges").val();
                var paid = $(this).val();
                var pending = total - paid;
                $("#CNRT_Charges_Pending").val(pending);
            });
            $(document).on('change', '#CNRT_CustomerID', function() {
                var client = $("#CNRT_CustomerID option:selected").data('client');
                if (typeof client != 'undefined') {
                    $('#CNRT_CustomerContactPerson').val(client.CCP_Name);
                    $('#CNRT_Phone1').val(client.CCP_Mobile);
                    $('#CNRT_Phone2').val(client.CCP_Phone1);
                    $('#CNRT_CustomerEmail').val(client.CCP_Email);
                    $('#CNRT_OfficeAddress').val(client.CST_OfficeAddress);
                } else {
                    $('#CNRT_CustomerContactPerson').val("");
                    $('#CNRT_Phone1').val("");
                    $('#CNRT_Phone2').val("");
                    $('#CNRT_CustomerEmail').val("");
                    $('#CNRT_OfficeAddress').val("");
                }
            });
            $(document).on('change', '#period_span', function() {
                var span = $(this).val();
                if (span == 0) {
                    $("#CNRT_EndDate").removeClass("disabled");
                } else {
                    $("#CNRT_EndDate").addClass("disabled");
                }
                span = span == "" || span == 0 ? 1 : span;
                var date = $('#CNRT_StartDate').val();
                var span = $("#period_span").val();
                span = span == "" || span == 0 ? 1 : span;
                var nd = date.split("-");
                date = nd[0] + "/" + nd[1] + "/" + nd[2];
                var d = new Date(date);
                var year = d.getFullYear();
                var month = d.getMonth();
                var day = d.getDate();
                var newYear = year + parseInt(span);
                var newMonth = month;
                var newDay = day - 1;
                if (newDay == 0) { // If the new day becomes 0, adjust the month and day accordingly
                    newMonth--;
                    if (newMonth < 0) {
                        newYear--;
                        newMonth = 11; // December
                    }
                    newDay = new Date(newYear, newMonth + 1, 0).getDate(); // Get the last day of the previous month
                }
                var c = new Date(newYear, newMonth, newDay);
                var monthStr = (c.getMonth() + 1) < 10 ? "0" + (c.getMonth() + 1) : (c.getMonth() + 1);
                var dayStr = c.getDate() < 10 ? "0" + c.getDate() : c.getDate();
                var fd = c.getFullYear() + "-" + monthStr + "-" + dayStr;
                $("#CNRT_EndDate").val(fd);
            });
            $(document).on('change', '#CNRT_StartDate', function() {
                var date = $(this).val();
                var span = $("#period_span").val();
                span = span == "" || span == 0 ? 1 : span;
                var nd = date.split("-");
                date = nd[0] + "/" + nd[1] + "/" + nd[2];
                var d = new Date(date);
                var year = d.getFullYear();
                var month = d.getMonth();
                var day = d.getDate();
                var newYear = year + parseInt(span);
                var newMonth = month;
                var newDay = day - 1;
                if (newDay == 0) { // If the new day becomes 0, adjust the month and day accordingly
                    newMonth--;
                    if (newMonth < 0) {
                        newYear--;
                        newMonth = 11; // December
                    }
                    newDay = new Date(newYear, newMonth + 1, 0).getDate(); // Get the last day of the previous month
                }
                var c = new Date(newYear, newMonth, newDay);
                var monthStr = (c.getMonth() + 1) < 10 ? "0" + (c.getMonth() + 1) : (c.getMonth() + 1);
                var dayStr = c.getDate() < 10 ? "0" + c.getDate() : c.getDate();
                var fd = c.getFullYear() + "-" + monthStr + "-" + dayStr;
                $("#CNRT_EndDate").val(fd);
            });

            function daysInMonth(year, month) {
                return new Date(year, month + 1, 0).getDate();
            }
        </script>
    @stop
</x-app-layout>