@extends('templates/app')
@section('title', 'Data Transaksi')
@section('subtitle', 'Tambah Transaksi')
@section('content')

<div class="card shadow mb-4">
    <div class="card-body">
        <p><strong>Tanggal Transaksi</strong> {{ date('Y-m-d H:i:s') }} </p> 
        <p><strong>Admin</strong> {{ session('username') }} </p>
    </div>
</div>

<div class="card shadow mb-4">
    <form action="/transaction/store" method="post">
		@csrf
        <div class="card-body">
            <input type="hidden" name="date" value="{{ date('Y-m-d H:i:s') }}" />
            <input type="hidden" name="user_id" value="{{ session('id') }}" />
            <div class="form-group">
                <label class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control" name="name_customer" />
                @error('name_customer') <small class="text-danger"> {{ $message }} </small> @enderror
            </div>
            <div id="drug-fields">
                <div class="row drug-field">
                    <div class="form-group col-md-6">
                        <label class="form-label">Pilih Obat</label>
                        <select class="choose-drug form-control select2" name="drug_code" onchange="updateTotal(this)">
                            <option selected disabled>Pilih salah satu</option>
                            @foreach($drugs as $drug)
                            <option value="{{ $drug->code }}" data-price="{{ $drug->price }}">{{ $drug->name_drug }}</option>
                            @endforeach
                        </select>
                        @error('drug_code') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" class="form-control qty" name="qty" oninput="updateTotal(this)" min="1" required>
                        @error('qty') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label class="form-label">Total</label>
                        <input type="text" name="total" class="total form-control" readonly>
                    </div>
                </div>
            </div>
            <button type="button" id="add-drug" class="btn btn-success">Tambah Obat</button>
            <div class="form-group mt-3">
                <label class="form-label">Total Keseluruhan</label>
                <input type="text" name="totalsemuanya" id="overall-total" class="form-control" readonly>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Buat Pesanan</button>
            <a href="/transaction" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

<script>
document.getElementById('add-drug').addEventListener('click', function() {
    let drugFields = document.getElementById('drug-fields');
    let newField = document.createElement('div');
    newField.classList.add('row', 'drug-field');
    newField.innerHTML = `
        <div class="form-group col-md-6">
            <label class="form-label">Pilih Obat</label>
            <select class="choose-drug form-control select2" name="drug_code" onchange="updateTotal(this)">
                <option selected disabled>Pilih salah satu</option>
                @foreach($drugs as $drug)
                <option value="{{ $drug->code }}" data-price="{{ $drug->price }}">{{ $drug->name_drug }}</option>
                @endforeach
            </select>
            @error('drug_code') <small class="text-danger"> {{ $message }} </small> @enderror
        </div>
        <div class="form-group col-md-3">
            <label class="form-label">Kuantitas</label>
            <input type="number" class="form-control qty" name="qty" oninput="updateTotal(this)" min="1" required>
            @error('qty') <small class="text-danger"> {{ $message }} </small> @enderror
        </div>
        <div class="form-group col-md-3">
            <label class="form-label">Total</label>
            <input type="text" name="total" class="total form-control" readonly>
        </div>
    `;
    drugFields.appendChild(newField);

    // Reinitialize Select2 on the new field
    $('.select2').select2();
});

function updateTotal(element) {
    let row = element.closest('.drug-field');
    let select = row.querySelector('.choose-drug');
    let qty = row.querySelector('.qty').value;
    let total = row.querySelector('.total');

    if (select && qty) {
        let price = select.options[select.selectedIndex].getAttribute('data-price');
        total.value = price * qty;
    }

    updateOverallTotal();
}

function updateOverallTotal() {
    let totalFields = document.querySelectorAll('.total');
    let overallTotal = 0;

    totalFields.forEach(function(field) {
        overallTotal += parseFloat(field.value) || 0;
    });

    document.getElementById('overall-total').value = overallTotal;
}
</script>
@stop
