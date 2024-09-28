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
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label for="customerID">ID Pelanggan</label>
                        <input type="text" name="customerID" id="customerID" class="form-control" value="{{ $customerData->id }}" readonly>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
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
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label for="technician">Teknisi</label>
                        <input type="text" name="technician" id="technician" class="form-control" value="{{ $techData->name }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div id="TechReportContainer">
            <div class="ac-report">
                @for ($i = 1; $i <= 1; $i++)
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">AC {{ $i }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <label for="location_{{ $i }}">Lokasi AC</label>
                                <input type="text" class="form-control" name="location_{{ $i }}" id="location_{{ $i }}" required><br>
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="brand_{{ $i }}">Merk</label>
                                <input type="text" class="form-control" name="brand_{{ $i }}" id="brand_{{ $i }}" required><br>
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="pk_{{ $i }}">PK</label>
                                <input type="text" name="pk_{{ $i }}" class="form-control" id="pk_{{ $i }}" required><br>
                            </div>
        
                            <div class="col-lg-6 col-12">
                                <label for="freon_{{ $i }}">Freon:</label>
                                <input class="form-control" type="text" name="freon_{{ $i }}" id="freon_{{ $i }}" required><br>
                            </div>
        
                            <div class="col-lg-6 col-12">
                                <label for="jenisLayanan_{{ $i }}">Jenis Layanan:</label>
                                <input class="form-control" type="text" name="jenisLayanan_{{ $i }}" id="jenisLayanan_{{ $i }}" required><br>
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="year_{{ $i }}">Tahun:</label>
                                <input class="form-control" type="number" name="year_{{ $i }}" id="year_{{ $i }}" required><br>
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="voltCondition_{{ $i }}">Volt:</label>
                                <select class="form-control" type="text" name="voltCondition_{{ $i }}" id="voltCondition_{{ $i }}" required>
                                    <option value="0">OFF</option>
                                    <option value="1">ON</option>
                                </select><br>
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="psiCondition_{{ $i }}">PSI:</label>
                                <select class="form-control" type="text" name="psiCondition_{{ $i }}" id="psiCondition_{{ $i }}" required>
                                    <option value="0">OFF</option>
                                    <option value="1">ON</option>
                                </select><br>
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="ampCondition_{{ $i }}">AMP:</label>
                                <select class="form-control" type="text" name="ampCondition_{{ $i }}" id="ampCondition_{{ $i }}" required>
                                    <option value="0">OFF</option>
                                    <option value="1">ON</option>
                                </select><br>
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="tempCondition_{{ $i }}">Temperatur Return & Supply:</label>
                                <select class="form-control" type="text" name="tempCondition_{{ $i }}" id="tempCondition_{{ $i }}" required>
                                    <option value="0">Return</option>
                                    <option value="1">Supply</option>
                                </select>
                                <br>
                            </div>
                        </div>
                    </div>
    
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Ambil Gambar {{ $i }}</h6>
                    </div>
    
                    <div class="card-body">
                        <video id="webcam_{{ $i }}" class="w-100 h-100" autoplay playsinline style="display:none;"></video>
                        <canvas class="w-100 h-100" id="canvas_{{ $i }}" style="display:none;"></canvas>
                        <img class="w-100 h-100" id="capturedPhoto_{{ $i }}" alt="Captured Photo" style="display:none;" />
                        <input id="capturedPhotoInput_{{ $i }}" name="capturedPhotoInput_{{ $i }}" type="hidden" />
                        <input data-form-count="{{$i}}" id="photoInput_{{ $i }}" name="photoInput_{{ $i }}" type="file" accept="image/png, image/jpg, image/jpeg" style="display: none; visibility: none"/>
    
                        <div class="d-flex flex-lg-row flex-column align-items-center mt-3" style="gap: 10px">
                            <button type="button" id="btnCapturePhoto_{{ $i }}" class="btn btn-success w-100 btn-add-customer" style="display:none;">Ambil Foto</button>
                            <button type="button" id="btnRetakePhoto_{{ $i }}" class="btn btn-warning w-100 btn-add-customer" style="display:none;">Foto Ulang</button>
                            <button type="button" id="btnStartWebcam_{{ $i }}" class="btn btn-primary w-100 btn-add-customer">Tambahkan Foto Dari Kamera</button>
                            <Label style="margin-bottom: unset" for="photoInput_{{ $i }}" id="btnPhotoInput_{{ $i }}" class="btn btn-primary w-100 btn-add-customer">Tambahkan Foto Dari File</Label>
                            <button type="button" id="btnFrontCamera_{{ $i }}" class="btn btn-info w-100 btn-add-customer" style="display:none;">Kamera Depan</button>
                            <button type="button" id="btnBackCamera_{{ $i }}" class="btn btn-info w-100 btn-add-customer" style="display:none;">Kamera Belakang</button>
                        </div>
                        <div class="col-12 mt-3" style="padding: unset;">
                            <label for="evaporatorCheck_{{ $i }}">Deskripsi Gambar</label>
                            <input class="form-control w-100" type="text" name="imageDesc_{{ $i }}" id="imageDesc_{{ $i }}" required><br>
                        </div>
                    </div>

                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Maintenance Check AC {{ $i }}</h6>
                    </div>
        
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <label for="evaporatorCheck_{{ $i }}">Evaporator Check</label>
                                <input type="checkbox" class="ml-2" name="evaporatorCheck_{{ $i }}" id="evaporatorCheck_{{ $i }}">
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="capasitorCheck_{{ $i }}">Capasitor Check</label>
                                <input type="checkbox" class="ml-2" name="capasitorCheck_{{ $i }}" id="capasitorCheck_{{ $i }}">
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="compresorCheck_{{ $i }}">Compresor Check</label>
                                <input type="checkbox" class="ml-2" name="compresorCheck_{{ $i }}" id="compresorCheck_{{ $i }}">
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="condensorCheck_{{ $i }}">Condensor Check</label>
                                <input type="checkbox" class="ml-2" name="condensorCheck_{{ $i }}" id="condensorCheck_{{ $i }}">
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="freonCheck_{{ $i }}">Freon Maintain</label>
                                <input type="checkbox" class="ml-2" name="freonCheck_{{ $i }}" id="freonCheck_{{ $i }}">
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="motorIndor_{{ $i }}">Monitor Fan Indoor</label>
                                <input type="checkbox" class="ml-2" name="motorIndor_{{ $i }}" id="motorIndor_{{ $i }}">
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="motorOutdor_{{ $i }}">Monitor Fan Outdoor</label>
                                <input type="checkbox" class="ml-2" name="motorOutdor_{{ $i }}" id="motorOutdor_{{ $i }}">
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="motorSwing_{{ $i }}">Motor Swing</label>
                                <input type="checkbox" class="ml-2" name="motorSwing_{{ $i }}" id="motorSwing_{{ $i }}">
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="pcbControl_{{ $i }}">PCB Control</label>
                                <input type="checkbox" class="ml-2" name="pcbControl_{{ $i }}" id="pcbControl_{{ $i }}">
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="pipaAc_{{ $i }}">Pipa AC</label>
                                <input type="checkbox" class="ml-2" name="pipaAc_{{ $i }}" id="pipaAc_{{ $i }}">
                            </div>
                            <div class="col-lg-6 col-12">
                                <label for="saluranDrain_{{ $i }}">Saluran Drain</label>
                                <input type="checkbox" class="ml-2" name="saluranDrain_{{ $i }}" id="saluranDrain_{{ $i }}">
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        <div class="d-flex justify-content-center py-3" style="gap: 10px">
            <button type="button" id="btnAddForm" class="btn btn-primary w-100 btn-add-customer">Tambahkan Data AC</button>
            <button type="submit" id="submitForm" class="btn btn-primary w-100 btn-add-customer">Submit</button>
        </div>
    </form>
</div>

@endSection

@section('scripts')

    <script src="{{ asset('js/reportTechnician.js') }}"></script>

@endSection