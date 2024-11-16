@extends('master')

@section('content')
<div class="layout-px-spacing pt-5 mt-5">

    <div class="middle-content container-xxl pt-5">
        <!-- Modal -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Detail Absensi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="detailModalContent">
                        <!-- Konten detail akan dimuat di sini -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- BREADCRUMB -->
        <div class="page-meta">
            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active" aria-current="page">List Absensi Karyawan</li>
                </ol>
            </nav>
        </div>
        <!-- /BREADCRUMB -->
        {{-- <div>
            <a href={{route('form-department')}} class="btn btn-primary">+ Tambah</a>
        </div> --}}

        <div class="row layout-top-spacing">
        
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <table id="zero-config" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Karywan</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th class="no-content">Action</th>
                            </tr>
                        </thead>
                        <tbody id="absent-data">
                            
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</div>
<script>
  async function loadAbsentData() {
        try {
            const token = `{{ Session::get('token') }}`;

            const response = await fetch('http://127.0.0.1:8100/api/attendance', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });            

            const data = await response.json(); // Pastikan API mengembalikan JSON

            console.log(data);
            if(data.response_code == '401'){
                alert('Sesi telah berakhir! Silahkan login kembali')
                await logout()
                throw new Error('Autentikasi Gagal!')
            }

            const tableBody = document.getElementById('absent-data');
            tableBody.innerHTML = ''; // Hapus data lama (jika ada)
            console.log(data);
            // Loop melalui data dan tambahkan ke tabel
            data.data.forEach(absent => {
                const row = `
                    <tr>
                        <td>${absent.id}</td>
                        <td>${absent.name}</td>
                        <td>${absent.clock_in}</td>
                        <td>${absent.clock_out}</td>
                        <td>
                            <button type="button" class="btn btn-secondary" onclick="showDetail('${absent.id}')">Detail Absensi</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        } catch (error) {
            console.error('Error fetching absent data:', error);
        }
    }

    async function logout() {
        try {
            const logoutResponse = await fetch('/logout', {
                method: 'POST',
            });

            const logoutData = await logoutResponse.json();
            alert('Sesi telah berakhir! Silahkan login kembali')
        } catch (error) {
            console.error('Error during logout:', error);
        }
    }

    // Fungsi untuk memuat data saat halaman dimuat
    document.addEventListener('DOMContentLoaded', loadAbsentData);
    async function logout() {
        try {
            const logoutResponse = await fetch('{{ route('logout') }}', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Sertakan CSRF token
                }
            });
            alert('Sesi telah berakhir! Silahkan login kembali')
        } catch (error) {
            console.error('Error during logout:', error);
        }
    }
    

    async function showDetail(absentId) {
        try {
            const token = `{{ Session::get('token') }}`;

            // Ambil data detail absensi dari API
            const response = await fetch(`http://127.0.0.1:8100/api/attendance-history/${absentId}`, {
                method: 'GET',
                headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                }
            });

            // Periksa status respons
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            // Parse respons sebagai JSON
            const data = await response.json();
            console.log('Detail Absensi:', data);

            // Tampilkan detail absensi di modal atau tempat lain
            displayDetailModal(data);

        } catch (error) {
            console.error('Error fetching attendance detail:', error);
            alert('Gagal memuat detail absensi. Silakan coba lagi.');
        }
    }

    function displayDetailModal(data) {
        let tableContent = `
            <h5 class="mb-3">Detail Absensi</h5>
            <div class="table-responsive">
            <table class="table dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Karyawan</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Tanggal Absensi</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
        `;

        // Iterasi data array
        data.data.forEach(absent => {
            tableContent += `
                <tr>
                    <td>${absent.id}</td>
                    <td>${absent.name}</td>
                    <td>${absent.clock_in}</td>
                    <td>${absent.clock_out}</td>
                    <td>${absent.date_attendance}</td>
                    <td>${absent.description}</td>
                </tr>
            `;
        });

        // Tutup tabel
        tableContent += `
                </tbody>
            </table>
        </div>
        `;

        const modalContainer = document.getElementById('detailModalContent');
        modalContainer.innerHTML = tableContent;

        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();
    }

    </script>
@endsection