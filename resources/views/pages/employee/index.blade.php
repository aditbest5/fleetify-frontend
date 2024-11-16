@extends('master')

@section('content')
<div class="layout-px-spacing pt-5 mt-5">

    <div class="middle-content container-xxl pt-5">

        <!-- BREADCRUMB -->
        <div class="page-meta">
            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Datatables</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Basic</li>
                </ol>
            </nav>
        </div>
        <!-- /BREADCRUMB -->
        <div>
            <a href={{route('form-employee')}} class="btn btn-primary">+ Tambah</a>
        </div>
        <div class="row layout-top-spacing">
        
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <table id="zero-config" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th class="no-content">Action</th>
                            </tr>
                        </thead>
                        <tbody id="employee-data">
                            
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</div>
<script>
  async function loadEmployeeData() {
        try {
            const token = `{{ Session::get('token') }}`;

            const response = await fetch('http://127.0.0.1:8100/api/employee/list', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });            
    
            const data = await response.json(); // Pastikan API mengembalikan JSON
            const tableBody = document.getElementById('employee-data');
            tableBody.innerHTML = '';
            console.log(data);
            if(data.response_code == '401'){
                alert('Sesi telah berakhir! Silahkan login kembali')
                await logout()
                throw new Error('Autentikasi Gagal!')
            }
            // Loop melalui data dan tambahkan ke tabel
            data.data.forEach(employee => {
                const row = `
                    <tr>
                        <td>${employee.id}</td>
                        <td>${employee.name}</td>
                        <td>${employee.address}</td>
                        <td>${employee.email}</td>
                        <td>${employee.department_name}</td>
                        <td class="d-flex flex-row gap-2">
                            <a class="btn btn-secondary btn-sm" href="/edit-employee/${employee.id}">Update</a>
                            <button class="btn btn-danger btn-sm" onclick="deleteEmployee('${employee.id}')">Delete</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        } catch (error) {
            console.error('Error fetching employee data:', error);
        }
    }

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

    // Fungsi untuk memuat data saat halaman dimuat
    document.addEventListener('DOMContentLoaded', loadEmployeeData);

    // Contoh fungsi hapus (tidak wajib, tergantung kebutuhan)
    async function deleteEmployee(id) {
        // Implementasikan logika penghapusan sesuai kebutuhan
        try {
            const token = `{{ Session::get('token') }}`;

            // Kirim request ke API dengan metode POST
            const response = await fetch(`http://127.0.0.1:8100/api/employee/delete/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
            });

            const data = await response.json();
            
            // Periksa apakah berhasil
            if (data.response_code === '200') {
                alert("Berhasil hapus data karyawan!");
                window.location.href="/employee-list"
            } else {
                alert("Terjadi kesalahan: " + data.response_message);
            }

        } catch (error) {
            console.error('Error deleting employee:', error);
            alert("Terjadi kesalahan saat menyimpan data!");
        }
    }
    </script>
@endsection