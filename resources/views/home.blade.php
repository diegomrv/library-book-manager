@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Dashboard</div>

				<div class="panel-body">
					<p>Welcome! You can do the following:</p>
					<ul>
						<li><a href="{{ route('book.index') }}">Manage books</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
