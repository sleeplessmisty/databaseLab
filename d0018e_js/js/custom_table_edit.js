$(document).ready(function(){
	$('#data_table').Tabledit({
		deleteButton: true,
		editButton: false, 
		restoreButton: false,

		buttons: {
        delete: {
            class: 'btn btn-sm btn-danger',
            html: '<span class="glyphicon glyphicon-trash"></span> &nbsp DELETE',
            //action: 'delete'
        },
        confirm: {
            class: 'btn',
            html: 'Are you sure?',
			action: 'delete',
        }
    	},  		
		columns: {
		  identifier: [0, 'id'],                    
		  editable: [[1, 'name'], [2, 'price'], [3, 'size'], [4, 'color'], [5, 'quantity'], [6, 'imgurl']]
		},
		hideIdentifier: true,
		//url: '/var/www/d0018e_js/php/live_edit.php'		
	});
});