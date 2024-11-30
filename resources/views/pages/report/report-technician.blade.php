@extends('layouts.main')

@section('title', 'Report')

@section('content')


<div class="card shadow-lg p-4 mb-3">
    <form action="{{ route('report.create', ['id' => $customerData->id]) }}" method="POST">
        @csrf

        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Service Report</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-12" hidden>
                    <div class="form-group">
                        <label for="customerID">ID Pelanggan</label>
                        <input type="text" name="customerID" id="customerID" class="form-control" value="{{ $customerData->id }}" readonly>
                    </div>
                </div>
                <div class="col-lg-6 col-12" hidden>
                    <div class="form-group">
                        <label for="techID">ID Teknisi</label>
                        <input type="text" name="techID" id="techID" class="form-control" value="{{ $techData->id }}" readonly>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label for="customerInput">Nama Customer</label>
                        <input type="text" name="customerInput" id="customerInput" class="form-control" value="{{ $customerData->name }}" readonly>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label for="taskDate">Tanggal Tugas</label>
                        <input type="date" name="taskDate" id="taskDate" class="form-control" value="{{ $customerData->created_at->format('Y-m-d') }}" readonly>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label for="reportDate">Tanggal Report</label>
                        <input type="date" name="reportDate" id="reportDate" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label for="addressCustomer">Alamat Customer</label>
                        <input type="text" name="addressCustomer" id="addressCustomer" class="form-control" value="{{ $customerData->address }}" readonly>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="technician">Teknisi</label>
                        <input type="text" name="technician" id="technician" class="form-control" value="{{ $techData->name }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div id="TechReportContainer">
            <div class="ac-report">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Technician Report</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <label for="device">Device</label>
                            <input type="text" class="form-control" name="device" id="device" required><br>
                        </div>
                        <div class="col-lg-6 col-12">
                            <label for="brand">Merk</label>
                            <input type="text" class="form-control" name="brand" id="brand" required><br>
                        </div>

                        <div class="col-12">
                            <label for="kerusakan" class="form-label">Kerusakan</label>
                            <textarea class="form-control" name="kerusakan" id="kerusakan" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Ambil Gambar</h6>
                </div>

                <div class="card-body">
                    <video id="webcam" class="w-100 h-100" autoplay playsinline style="display:none;"></video>
                    <canvas class="w-100 h-100" id="canvas" style="display:none;"></canvas>
                    <img class="w-100 h-100" id="capturedPhoto" alt="Captured Photo" style="display:none;" />
                    <input id="capturedPhotoInput" name="capturedPhotoInput" type="hidden" />
                    <input id="photoInput" name="photoInput" type="file" accept="image/png, image/jpg, image/jpeg" style="display: none; visibility: none"/>

                    <div class="d-flex flex-lg-row flex-column align-items-center mt-3" style="gap: 10px">
                        <button type="button" id="btnCapturePhoto" class="btn btn-success w-100 btn-add-customer" style="display:none;">Ambil Foto</button>
                        <button type="button" id="btnRetakePhoto" class="btn btn-warning w-100 btn-add-customer" style="display:none;">Foto Ulang</button>
                        <button type="button" id="btnStartWebcam" class="btn btn-primary w-100 btn-add-customer">Tambahkan Foto Dari Kamera</button>
                        <Label style="margin-bottom: unset" for="photoInput" id="btnPhotoInput" class="btn btn-primary w-100 btn-add-customer">Tambahkan Foto Dari File</Label>
                        <button type="button" id="btnFrontCamera" class="btn btn-info w-100 btn-add-customer" style="display:none;">Kamera Depan</button>
                        <button type="button" id="btnBackCamera" class="btn btn-info w-100 btn-add-customer" style="display:none;">Kamera Belakang</button>
                    </div>
                    <div class="col-12 mt-3" style="padding: unset;">
                        <label for="evaporatorCheck">Deskripsi Gambar</label>
                        <input class="form-control w-100" type="text" name="imageDesc" id="imageDesc" required><br>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center py-3">
            <button type="submit" id="submitForm" class="btn btn-primary w-50 btn-add-customer">Submit</button>
        </div>
    </form>
</div>

@endSection

@section('scripts')

    <script src="{{ asset('js/reportTechnician.js') }}"></script>

@endSection