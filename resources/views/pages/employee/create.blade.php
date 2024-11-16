@extends('master')
@section('content')
    
<div class="container pt-5">

    <div class="container pt-5">
        
        <div class="row layout-top-spacing">

            <div class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">                                
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Tambah Data Karyawan</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <form>
                            <div class="form-group mb-4">
                                <label for="exampleFormControlInput2">Nama Lengkap</label>
                                <input type="text" class="form-control" name="name" id="exampleFormControlInput2" placeholder="Ex. John Doe">
                            </div> 
                            <div class="form-group mb-4">
                                <label for="exampleFormControlInput2">Email address</label>
                                <input type="email" class="form-control" name="email" id="exampleFormControlInput2" placeholder="Ex. name@example.com">
                            </div>
                            <div class="form-group mb-4">
                                <label for="selectDepartment">Pilih Departemen</label>
                                <select class="form-select" name="department_id" id="selectDepartment">
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="exampleFormControlTextarea1">Alamat</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="address" rows="3"></textarea>
                            </div>
                            <button class="mt-4 mb-4 btn btn-primary" type="button" onclick="saveEmployee()">Submit</button>
                        </form>
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

    document.addEventListener('DOMContentLoaded', loadDepartments);
    async function saveEmployee() {
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
            const response = await fetch('http://127.0.0.1:8100/api/employee/create', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();
            
            // Periksa apakah berhasil
            if (data.response_code === '200') {
                alert("Karyawan berhasil disimpan!");
                window.location.href="/employee-list"
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
