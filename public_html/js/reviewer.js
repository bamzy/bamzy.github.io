/**
 * Created by bamdad on 2/12/2016.
 */
var url;
function newReviewer() {
    $('#reviewerDlg').dialog('open').dialog('setTitle', 'New Reviewer');
    $('#reviewerFm').form('clear');
    url = 'saveReviewer.php';
}
function editReviewer() {
    var row = $('#reviewerTable').datagrid('getSelected');
    if (row) {
        $('#reviewerDlg').dialog('open').dialog('setTitle', 'Edit Reviewer');
        $('#reviewerFm').form('load', row);
        url = 'updateReviewer.php?id=' + row.id;
    }
}
function saveReviewer() {
    $('#reviewerFm').form('submit', {
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
                $('#reviewerDlg').dialog('close');		// close the dialog
                $('#ReviewerTable').datagrid('reload');	// reload the user data
            }
        }
    });
}
function deleteReviewer() {
    var row = $('#reviewerTable').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirm', 'Are you sure you want to destroy this user?', function (r) {
            if (r) {
                $.post('deleteReviewer.php', {id: row.id}, function (result) {
                    if (result.success) {
                        $('#reviewerTable').datagrid('reload');	// reload the user data
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
