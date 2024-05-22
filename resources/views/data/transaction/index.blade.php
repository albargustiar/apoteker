@extends('templates/app')
@section('title', 'Data Transaction')
@section('subtitle', 'Transactions List')
@section('content')

<div class="card shadow mb-4">
	<div class="card-body">
		@if (session('created'))
			<div class="alert alert-success">
				{{ session('created') }}
			</div>
		@elseif (session('updated'))
			<div class="alert alert-success">
				{{ session('updated') }}
			</div>
		@elseif (session('deleted'))
			<div class="alert alert-success">
				{{ session('deleted') }}
			</div>
		@endif

		<div class="d-flex mb-3">
			<a class="btn btn-secondary" href="/transaction/create">Create New Transaction</a>
			<form action="/transaction/delete-all" method="post" class="ml-auto">
				@csrf
				@method('delete')
				<button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete all transactions?');">Delete All</button>
			</form>
		</div>

		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Date</th>
						<th>Name Customer</th>
						<th>Admin</th>
						<th>Opsi</th>
					</tr>
				</thead>
				<tbody>
					@foreach($transaction as $transaction)
					<tr>
						<td>{{ $transaction->date }}</td>
						<td>{{ $transaction->name_customer }}</td>
						<td>{{ $transaction->user->username }}</td>
						<td>
							<a class="btn btn-info" href="/transaction/show/{{ $transaction->id }}">detail</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
