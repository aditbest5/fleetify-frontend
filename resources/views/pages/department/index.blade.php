@extends('master')

@section('content')
<div class="layout-px-spacing pt-5 mt-5">

    <div class="middle-content container-xxl pt-5">

        <!-- BREADCRUMB -->
        <div class="page-meta">
            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Department</li>
                </ol>
            </nav>
        </div>
        <!-- /BREADCRUMB -->
        <div>
            <a href={{route('form-department')}} class="btn btn-primary">+ Tambah</a>
        </div>

        <div class="row layout-top-spacing">
        
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <table id="zero-config" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Department Name</th>
                                <th>Max Clock In</th>
                                <th>Max Clock Out</th>
                                <th class="no-content">Action</th>
                            </tr>
                        </thead>
                        <tbody id="department-data">
                            
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</div>
<script>
  async function loadDepartmentData() {
        try {
            const token = `{{ Session::get('token') }}`;

            const response = await fetch('http://127.0.0.1:8100/api/department', {
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

            const tableBody = document.getElementById('department-data');
            tableBody.innerHTML = ''; // Hapus data lama (jika ada)
            console.log(data);
            // Loop melalui data dan tambahkan ke tabel
            data.data.forEach(department => {
                const row = `
                    <tr>
                        <td>${department.id}</td>
                        <td>${department.department_name}</td>
                        <td>${department.max_clock_in_time}</td>
                        <td>${department.max_clock_out_time}</td>
                        <td>
                            <a class="btn btn-secondary btn-sm" href="/edit-department/${department.id}">Update</a>
                            <button class="btn btn-danger btn-sm" onclick="deleteDepartment('${department.id}')">Delete</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        } catch (error) {
            console.error('Error fetching department data:', error);
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
    document.addEventListener('DOMContentLoaded', loadDepartmentData);
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
    async function deleteDepartment(id) {
        // Implementasikan logika penghapusan sesuai kebutuhan
        try {
            const token = `{{ Session::get('token') }}`;

            // Kirim request ke API dengan metode POST
            const response = await fetch(`http://127.0.0.1:8100/api/department/delete/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
            });

            const data = await response.json();
            
            // Periksa apakah berhasil
            if (data.response_code === '200') {
                alert("Berhasil hapus data departemen!");
                window.location.href="/department-list"
            } else {
                alert("Terjadi kesalahan: " + data.response_message);
            }

        } catch (error) {
            console.error('Error deleting department:', error);
            alert("Terjadi kesalahan saat menyimpan data!");
        }
    }
    </script>
@endsection