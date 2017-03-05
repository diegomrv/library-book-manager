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
								<td class="text-center">{{ isset($item->user)? 'No' : 'Yes' }}</td>
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
@endsection
