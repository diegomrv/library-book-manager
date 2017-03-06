
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap-datepicker');
require('select2');

$(document).ready(function(){

	initialize_tooltips();

	$('.category-dropdown').select2();

	$('#change-status').on('show.bs.modal', function(event){
		var book = $(event.relatedTarget).data('book');
		
		if(book.user == null){
			$('h4', this).html('Borrow book');
			$('.verb', this).html('borrow');
		}else{
			$('h4', this).html('Deliver book');
			$('.verb', this).html('deliver');
		}

		$('.book_name', this).html(book.name);
		$('.book_author', this).html(book.author);;
		$('.confirm', this).data('bookid', book.id);
	});

	$('#change-status').on('click', 'button.confirm', function(){

		var confirm_btn = $(this);

		$.ajax({
			url: '/book/'+confirm_btn.data('bookid')+'/borrow_book',
			type: 'POST',
			data: {'_token': window.Laravel.csrfToken},
			dataType: 'json',
			success: function(data){
				confirm_btn.parents('#change-status').modal('hide');

				if(data.type == 'borrow'){
					$('.is-available-'+confirm_btn.data('bookid')).html('<a data-toggle="modal" data-target="#change-status" data-book="'+data.book+'"><span data-toggle="tooltip" data-placement="top" title="'+data.user_name+'">No</span></a>');	
				}else{
					$('.is-available-'+confirm_btn.data('bookid')).html('<span data-toggle="modal" data-target="#change-status" data-book="'+data.book+'">Yes</span>');
				}

				
				initialize_tooltips();
			}
		});
	});
});


function initialize_tooltips(){
	$('[data-toggle="tooltip"]').tooltip();
}