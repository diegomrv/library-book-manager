@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">New book</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ route('book.store') }}">
						<div class="form-group">
							<label for="name" class="col-md-4 control-label">Name</label>

							<div class="col-md-6">
								<input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" autofocus >
								@if ($errors->has('name'))
									<span class="help-block">
										<strong>{{ $errors->first('name') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group">
							<label for="author" class="col-md-4 control-label">Author</label>

							<div class="col-md-6">
								<input type="text" id="author" name="author" class="form-control" value="{{ old('author') }}" >
								@if ($errors->has('author'))
									<span class="help-block">
										<strong>{{ $errors->first('author') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group">
							<label for="published_date" class="col-md-4 control-label">Published Date</label>

							<div class="col-md-6">
								<div class="input-group date" data-provide="datepicker">
									<input type="text" id="published_date" name="published_date" class="form-control" value="{{ old('published_date') }}" readonly >
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</div>
								</div>
								@if ($errors->has('published_date'))
									<span class="help-block">
										<strong>{{ $errors->first('published_date') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group">
							<label for="category_id" class="col-md-4 control-label">Category</label>

							<div class="col-md-6">
								<select id="category_id" name="category_id" class="form-control category-dropdown">
									@foreach ($categories as $category)
									<option value="{{ $category->id }}">{{ $category->name }}</option>
									@endforeach
								</select>
								@if ($errors->has('category_id'))
									<span class="help-block">
										<strong>{{ $errors->first('category_id') }}</strong>
									</span>
								@endif
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								{{ csrf_field() }}
								<button type="submit" class="btn btn-primary">Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
