<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Report</title>
</head>

<body>
    <style>
        @page {
            margin-top: 13rem;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .header-report {
            text-align: center;
            position: fixed;
            top: -10rem;
            left: 0;
            right: 0;
        }

        h1, h2, h4, h5 {
            margin: 10px 0;
            font-size: 14px
        }

        p {
            margin: 5px 0;
            font-size: 12px
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            font-size: 12px
        }

        td {
            vertical-align: top;
        }

        #report_info td {
            vertical-align: unset;
        }

        table table {
            margin-bottom: unset;
        }

        th {
            background-color: #f2f2f2;
            font-size: 12px
        }

        .caption-table {
            background: #f2f2f2;
            font-size: 12px;
            padding: 10px;
        }
    </style>

    <div class="header-report">
        <img src="{{ public_path('images/logo-brand.png') }}" alt="Logo Brand" width="80">
        {{-- <img src="{{ asset('images/logo-brand.jpeg') }}" alt="Logo Brand" width="40"> --}}
        <h2 class="header-report-title">PT. WANDA INDONESIA TEKNOLOGI </h2>
        <p>
            OFFICE : Jalan Platina 2, Curug, Kec. Gn. Sindur, Kabupaten Bogor, Jawa Barat 16340, Indonesia.<br>
            Telp: 085760340080 | Email: teknologi.wit@gmail.com  | www.wit.id
        </p>

        <hr>
    </div>

    <div class="report-container">
        <table id="report_info" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th colspan="4" style="text-align: center">SERVICE REPORT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="caption-table">Nama Pelanggan :</td>
                    <td style="font-weight: bold">{{ $customerData->name }}</td>

                    <td class="caption-table">Alamat Pelanggan :</td>
                    <td>{{ $customerData->address }}</td>
                </tr>
                <tr>
                    <td class="caption-table">Tanggal Pesanan :</td>
                    <td style="font-weight: bold">{{ $reportData->taskDate }}</td>

                    <td class="caption-table">Tanggal Laporan :</td>
                    <td>{{ $reportData->reportDate }}</td>
                </tr>
                <tr>
                    <td class="caption-table">Teknisi :</td>
                    <td style="font-weight: bold">{{ $techData->name }} ({{$techData->phone}})</td>

                    <td class="caption-table">ID Report :</td>
                    <td>{{ $reportData->id }}</td>
                </tr>
            </tbody>
        </table>
        @foreach($acDatas as $index => $acData)
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th>{{$index+1}}. AC {{$index+1}} ({{$acData->ac_location}})</th>
                        <th>KONDISI AC</th>
                        <th colspan="2">MAINTENANCE CHECK</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <table>
                                <thead>
                                    <th>SPESIFIKASI</th>
                                </thead>
                                <tbody>
                                    <td>
                                        Merk: {{$acData->merk}}<br>
                                        PK: {{$acData->pk}}<br>
                                        Freon: {{$acData->freyon}}<br>
                                        Tahun: {{$acData->tahun}}
                                    </td>
                                </tbody>
                            </table>
                            <table>
                                <thead>
                                    <th>JENIS LAYANAN</th>
                                </thead>
                                <tbody>
                                    <td>
                                        {{$acData->jenis_layanan}}
                                    </td>
                                </tbody>
                            </table>
                        </td>
        
                        <!-- Kolom KONDISI AC -->
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td><strong>OFF</strong></td>
                                        <td><strong>ON</strong></td>
                                    </tr>
                                    <tr>
                                        <td>VOLT</td>
                                        @if ($acData->volt == 0)
                                            <td>OFF</td>
                                            <td></td>
                                        @endif
                                        @if ($acData->volt == 1)
                                            <td>OFF</td>
                                            <td></td>
                                        @endif    
                                    </tr>
                                    <tr>
                                        <td>AMP</td>
                                        @if ($acData->amp == 0)
                                            <td>OFF</td>
                                            <td></td>
                                        @endif
                                        @if ($acData->amp == 1)
                                            <td>OFF</td>
                                            <td></td>
                                        @endif 
                                    </tr>
                                    <tr>
                                        <td>PSI</td>
                                        @if ($acData->psi == 0)
                                            <td>OFF</td>
                                            <td></td>
                                        @endif
                                        @if ($acData->psi == 1)
                                            <td>OFF</td>
                                            <td></td>
                                        @endif 
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>RETURN</strong></td>
                                        <td><strong>SUPPLY</strong></td>
                                    </tr>
                                    <tr>
                                        <td>TEMP</td>
                                        @if ($acData->temp == 0)
                                            <td>RETURN</td>
                                            <td></td>
                                        @endif
                                        @if ($acData->temp == 1)
                                            <td>SUPPLY</td>
                                            <td></td>
                                        @endif 
                                    </tr>
                                </tbody>
                            </table>
                        </td>
        
                        <!-- Kolom MAINTENANCE CHECK -->
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>EVAPORATOR</td>
                                        <td>{{strtoupper($acData->evaporator)}}</td>
                                    </tr>
                                    <tr>
                                        <td>CAPASITOR</td>
                                        <td>{{strtoupper($acData->capasitor)}}</td>
                                    </tr>
                                    <tr>
                                        <td>COMPRESOR</td>
                                        <td>{{strtoupper($acData->compresor)}}</td>
                                    </tr>
                                    <tr>
                                        <td>CONDENSOR</td>
                                        <td>{{strtoupper($acData->condensor)}}</td>
                                    </tr>
                                    <tr>
                                        <td>FREON</td>
                                        <td>{{strtoupper($acData->freon_maintain)}}</td>
                                    </tr>
                                    <tr>
                                        <td>MOTOR FAN INDOOR</td>
                                        <td>{{strtoupper($acData->monitor_fan_indoor)}}</td>
                                    </tr>
                                    <tr>
                                        <td>MOTOR FAN OUTDOOR</td>
                                        <td>{{strtoupper($acData->monitor_fan_outdoor)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>MOTOR SWING</td>
                                        <td>{{strtoupper($acData->motor_swing)}}</td>
                                    </tr>
                                    <tr>
                                        <td>PCB CONTROL</td>
                                        <td>{{strtoupper($acData->pcb_control)}}</td>
                                    </tr>
                                    <tr>
                                        <td>PIPA AC</td>
                                        <td>{{strtoupper($acData->pipa_ac)}}</td>
                                    </tr>
                                    <tr>
                                        <td>SALURAN DRAIN</td>
                                        <td>{{strtoupper($acData->saluran_drain)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endforeach
        
        @if($acDatas->count() > 0)
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th colspan="4" style="text-align: center">DOKUMENTASI</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="caption-table">FOTO DOKUMENTASI</td>
                        <td class="caption-table">KETERANGAN</td>
                    </tr>
                    @foreach($acDatas as $acData)
                        <tr>
                            <td><img width="450" src="/{{$acData->imageUrl}}" alt="{{$acData->imageDesc}}"></td>
                            <td>
                                <b>Tanggal Foto: </b>{{$reportData->created_at}}<br>
                                <b>Teknisi: </b>{{$techData->name}}<br>
                                <b>Keterangan: </b>{{$acData->imageDesc}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</body>

</html>

