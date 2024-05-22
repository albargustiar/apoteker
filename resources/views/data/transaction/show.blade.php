@extends('templates/app')
@section('title', 'Data Transaction')
@section('subtitle', 'Detail Transaction')
@section('content')

<div class="card shadow mb-4">
	<div class="card-header d-flex justify-content-between">
		<a class="btn btn-secondary" href="/transaction">Back</a>
		<form action="/transaction/delete/{{ $transaction->id }}" method="post">
			@method("delete")
			@csrf
			<button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</button>
		</form>
	</div>
	<div class="card-body">
		<div class="receipt">
			<div class="receipt-header text-center mb-3">
				<h5>Klinik Sumber Sehat</h5>
				--------------------------------
				<p>Tel: (021) 12345678</p>
				<p>Date: {{ $transaction->date }}</p>
			</div>
			<div class="receipt-body">
				<table class="table table-sm table-borderless">
					<tr style="color: #000">
						<td><strong>Nama Pasien:</strong></td>
						<td>{{ $transaction->name_customer }}</td>
					</tr>
					<tr style="color: #000">
						<td><strong>Qty:</strong></td>
						<td>{{ $transaction->qty }}</td>
					</tr>
					<tr style="color: #000">
						<td><strong>Total Price:</strong></td>
						<td>Rp. {{ number_format($transaction->totalsemuanya, 0, ',', '.') }}</td>
					</tr>
				</table>
			</div>
			<div class="receipt-footer text-center mt-3">
				<p>--------------------------------</p>
				<p>Semoga Lekas Sembuh</p>
			
			
			</div>
		</div>
	</div>
</div>

<style>
.receipt {
	border: 1px dashed #000;
	color: #000;
	padding: 15px;
	font-family: 'Courier New', Courier, monospace;
	font-size: 12px;
	max-width: 300px;
	margin: auto;
}
.receipt-header,
.receipt-footer {
	margin-bottom: 10px;
}
</style>
@stop
