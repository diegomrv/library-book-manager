@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			@if(Session::has('msg'))
				<div class="alert alert-{{ Session::get('msg.type') }} alert dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					{{ Session::get('msg.text') }}
				</div>
			@endif
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-6"><h4>Books</h4></div>
						<div class="col-md-6 text-right"><a href="{{ route('book.create') }}" class="btn btn-default">New book</a></div>
					</div>
				</div>

				<div class="panel-body">
					<table class="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Author</th>
								<th>Category</th>
								<th>Published</th>
								<th class="text-center">Available?</th>
								<th width="90" class="text-center">Edit</th>
								<th width="90" class="text-center">Delete</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($list_items as $item)
							<tr>
								<td>{{ $item->name }}</td>
								<td>{{ $item->author }}</td>
								<td>{{ $item->category->name }}</td>
								<td>{{ $item->published_date->formatLocalized('%m/%d/%Y') }}</td>
								<td class="text-center is-available-{{ $item->id }}">
									@if(isset($item->user))
										<a data-toggle="modal" data-target="#change-status" data-book="{{ $item->toJson() }}"><span data-toggle="tooltip" data-placement="top" title="{{ $item->user->name }}">No</span></a>
									@else
										<span data-toggle="modal" data-target="#change-status" data-book="{{ $item->toJson() }}">Yes</span>
									@endif
								</td>
								<td class="text-center"><a href="{{ route('book.edit', $item->id) }}"><span class="glyphicon glyphicon-edit"></span></a></td>
								<td class="text-center">
									<form class="delete-form" action="{{ route('book.destroy', $item->id) }}" method="POST">
										{{ method_field('delete') }}
										{{ csrf_field() }}
										<button type="submit"><span class="glyphicon glyphicon-trash text-primary"></span></button>
									</form>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>

					{{ $list_items->links() }}
				</div>
			</div>
		</div>
	</div>
</div>

{{-- Book lending modal --}}
<div id="change-status" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4></h4>
			</div>
			<div class="modal-body">
				<p>Please confirm that you wish to <span class="verb">borrow</span>:</p>
				<h3 class="book_name"></h3> 
				<p>by</p>
				<h4 class="book_author"></h4>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary confirm" data-bookid="0">Confirm</button>
			</div>
		</div>
	</div>
</div>

@endsection
