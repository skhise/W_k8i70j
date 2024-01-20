function fnDisPageErrors(PageName, ErrorMsg) {
    iziToast.error({
        title: PageName,
        message: ErrorMsg,
        position: 'topRight'
    });
} 