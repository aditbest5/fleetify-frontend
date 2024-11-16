@extends('master')
@section('content')
<div class="layout-px-spacing">

    <div class="middle-content container-xxl p-0">

        <!-- BREADCRUMB -->
        <div class="page-meta">
            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Profile</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Account Settings</li>
                </ol>
            </nav>
        </div>
        <!-- /BREADCRUMB -->
            
        <div class="account-settings-container layout-top-spacing">

            <div class="account-content pt-5">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h2>Settings</h2>
                    </div>
                </div>

                <div class="tab-content" id="animateLineContent-4">
                    <div class="tab-pane fade show active" id="animated-underline-home" role="tabpanel" aria-labelledby="animated-underline-home-tab">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <div class="info">
                                        <h6 class="">General Information</h6>
                                        <div class="row">
                                            <div class="col-lg-11 mx-auto">
                                                <div class="row">

                                                    <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
                                                        <div class="form">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="fullName">Nama Lengkap</label>
                                                                        <input type="text" class="form-control mb-3" name="name" id="fullname" placeholder="Full Name" >
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="profession">Email</label>
                                                                        <input type="email" class="form-control mb-3" name="email" id="email" placeholder="name@example.com">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="selectDepartment">Departemen</label>
                                                                        <select class="form-select mb-3" name="department_id" id="selectDepartment">
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="address">Address</label>
                                                                        <textarea type="text" name="address" class="form-control mb-3" id="address" placeholder="Address"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 mt-1">
                                                                    <div class="form-group text-end">
                                                                        <button type="button" onclick="updateEmployee('{{$id}}')" class="btn btn-secondary">Save</button>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>

    </div>

</div>
<script>
    async function loadDepartments() {
        try {
            // Ambil token Bearer dari session atau variable lain
            const token = `{{ Session::get('token') }}`;

            // Lakukan fetch ke endpoint API untuk mendapatkan daftar departemen
            const response = await fetch('http://127.0.0.1:8100/api/department', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json(); // Parse response sebagai JSON

            // Ambil elemen select untuk departemen
            const selectDepartment = document.getElementById('selectDepartment');

            // Clear existing options (jika ada)
            selectDepartment.innerHTML = '';

            // Loop dan tambahkan departemen ke dalam option
            data.data.forEach(department => {
                const option = document.createElement('option');
                option.value = department.id;  // Menggunakan id sebagai value
                option.textContent = department.department_name;  // Menggunakan nama departemen untuk label
                selectDepartment.appendChild(option);
            });

        } catch (error) {
            console.error('Error fetching departments:', error);
        }
    }

    document.addEventListener('DOMContentLoaded', onDOMContentLoaded);
    function onDOMContentLoaded() {
        loadDepartments();
        loadEmployeeData();
    }
      async function loadEmployeeData() {
        try {
            const token = `{{ Session::get('token') }}`;
            const response = await fetch('http://127.0.0.1:8100/api/employee/list/{{$id}}', {
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

            document.querySelector('input[name="name"]').value = data.data.name;
            document.querySelector('input[name="email"]').value = data.data.email;
            document.querySelector('textarea[name="address"]').value = data.data.address;

            const selectDepartment = document.querySelector('select[name="department_id"]');
            selectDepartment.value = data.data.department_id; // Pilih departemen sesuai department_id dari data karyawan
            
        } catch (error) {
            console.error('Error fetching employee data:', error);
        }
    }

    async function updateEmployee(id) {
        try {
            const token = `{{ Session::get('token') }}`;
            
            // Ambil data dari form
            const name = document.querySelector('input[name="name"]').value;
            const email = document.querySelector('input[name="email"]').value;
            const departmentId = document.querySelector('select[name="department_id"]').value;
            const address = document.querySelector('textarea[name="address"]').value;

            // Validasi input
            if (!name || !email || !departmentId || !address) {
                alert("Semua field harus diisi!");
                return;
            }

            // Data yang akan dikirim ke API
            const payload = {
                name: name,
                email: email,
                department_id: departmentId,
                address: address
            };

            // Kirim request ke API dengan metode POST
            const response = await fetch(`http://127.0.0.1:8100/api/employee/update/${id}`, {
                method: 'PATCH',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();
            
            // Periksa apakah berhasil
            if (data.response_code === '200') {
                alert("Data diri berhasil diubah!");
                window.location.href="/profile"
            } else {
                alert("Terjadi kesalahan: " + data.response_message);
            }

        } catch (error) {
            console.error('Error saving employee:', error);
            alert("Terjadi kesalahan saat menyimpan data!");
        }
    }
</script>
@endsection