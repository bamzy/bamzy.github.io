/**
 * Created by bamdad on 2/12/2016.
 */
var url;
function assignReviewer() {
    $('#manuscriptDlg').dialog('open').dialog('setTitle', 'New Manuscript');
    $('#manuscriptFm').form('clear');
    url = 'saveManuscript.php';
}
function editReview() {
    var row = $('#manuscriptTable').datagrid('getSelected');
    if (row) {
        $('#manuscriptDlg').dialog('open').dialog('setTitle', 'Edit Manuscript');
        $('#manuscriptFm').form('load', row);
        url = 'updateManuscript.php?id=' + row.id;
    }
}
function saveReview() {
    $('#manuscriptFm').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (result) {
            var result = eval('(' + result + ')');
            if (result.errorMsg) {
                $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                });
            } else {
                $('#manuscriptDlg').dialog('close');		// close the dialog
                $('#manuscriptTable').datagrid('reload');	// reload the user data
            }
        }
    });
}
function deleteReview() {
    var row = $('#manuscriptTable').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirm', 'Are you sure you want to destroy this manuscript?', function (r) {
            if (r) {
                $.post('deleteManuscript.php', {id: row.id}, function (result) {
                    if (result.success) {
                        $('#manuscriptTable').datagrid('reload');	// reload the user data
                    } else {
                        $.messager.show({	// show error message
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    }
                }, 'json');
            }
        });
    }
}
//
//$("#manuscriptTable").datagrid.(function() {
//    //var selected = $(this).hasClass("highlight");
//    //$("#data tr").removeClass("highlight");
//    //if(!selected)
//});

function loadAssociatedReviewers() {
    var row = $('#manuscriptTable').datagrid('getSelected');
    if (row) {
        //$.messager.confirm('Confirm', 'Are you sure you want to destroy this manuscript?', function (r) {
        //    if (r) {
        //$.post('listAssociatedReviewers.php', {id: row.id}, function (result) {
        //$('#associateReviewTable').datagrid('reload');	// reload the user data
        $('#associateReviewTable').datagrid('reload', {
            id: row.id,

        });
        //$.post('listAssociatedReviewers.php', {id: 1}, function (result) {
        //    if (result) {
        //        console.log('1\n');
        //        $('#associateReviewTable').datagrid('reload');	// reload the user data
        //    } else {
        //
        //        console.log(result.errorMsg);
        //        $.messager.show({	// show error message
        //            title: 'Error',
        //            msg: result.errorMsg
        //        });
        //    }
        //}, 'json');
    }
    //});

}