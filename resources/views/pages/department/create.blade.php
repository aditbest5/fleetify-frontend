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
                                <h4>Tambah Data Departemen</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <form>
                            <div class="form-group mb-4">
                                <label for="exampleFormControlInput2">Nama Departemen</label>
                                <input type="text" class="form-control" name="department_name" id="exampleFormControlInput2" placeholder="Ex. John Doe">
                            </div> 
                            <div class="form-group mb-4">
                                <label for="exampleFormControlInput2">Waktu Maksimal Clock In</label>
                                <input type="time" class="form-control" name="max_clock_in_time" id="exampleFormControlInput2" placeholder="Ex. name@example.com">
                            </div>
                            <div class="form-group mb-4">
                                <label for="selectDepartment">Waktu Maksimal Clock Out</label>
                                <input type="time" class="form-control" name="max_clock_out_time"/>
                            </div>
                            <button class="mt-4 mb-4 btn btn-primary" type="button" onclick="saveDepartment()">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>                
    </div>
</div>
<script>

    async function saveDepartment() {
        try {
            const token = `{{ Session::get('token') }}`;
            
            // Ambil data dari form
            const departemen_name = document.querySelector('input[name="department_name"]').value;
            const max_clock_in_time = document.querySelector('input[name="max_clock_in_time"]').value;
            const max_clock_out_time = document.querySelector('input[name="max_clock_out_time"]').value;

            // Validasi input
            if (!departemen_name || !max_clock_in_time || !max_clock_out_time) {
                alert("Semua field harus diisi!");
                return;
            }

            // Data yang akan dikirim ke API
            const payload = {
                department_name: departemen_name,
                max_clock_in_time: max_clock_in_time,
                max_clock_out_time: max_clock_out_time,
            };

            // Kirim request ke API dengan metode POST
            const response = await fetch('http://127.0.0.1:8100/api/department/create', {
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
                alert("Department berhasil disimpan!");
                window.location.href="/department-list"
            } else {
                alert("Terjadi kesalahan: " + data.response_message);
            }

        } catch (error) {
            console.error('Error saving department:', error);
            alert("Terjadi kesalahan saat menyimpan data!");
        }
    }
</script>
@endsection