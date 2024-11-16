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
                                <h4>Absen Pulang</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <form>
                            <div class="form-group mb-4">
                                <label for="exampleFormControlInput2">Jam Pulang</label>
                                <input type="datetime-local" class="form-control" name="clock_out" id="clockOut" readonly/>
                            </div>
                            <div class="form-group mb-4">
                                <label for="exampleFormControlInput2">Tanggal Absen</label>
                                <input type="datetime-local" id="dateAttendance" class="form-control" name="date_attendance" readonly/>
                            </div>
                            <button class="mt-4 mb-4 btn btn-primary" type="button" onclick="saveAbsent()">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>                
    </div>
</div>
<script>

async function saveAbsent() {
        try {
            const token = `{{ Session::get('token') }}`;
            
            // Ambil data dari form
            const clock_out = document.querySelector('input[name="clock_out"]').value;
            const date_attendance= document.getElementById('dateAttendance').value;

            // Validasi input
            if (!clock_out || !date_attendance) {
                alert("Semua field harus diisi!");
                return;
            }

            // Data yang akan dikirim ke API
            const payload = {
                clock_out: clock_out,
                date_attendance: date_attendance,
            };

            // Kirim request ke API dengan metode POST
            const response = await fetch('http://127.0.0.1:8100/api/attendance/absent_out', {
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
                alert("Berhasil Absen Pulang!");
                window.location.href="/absent-out"
            } else {
                alert("Terjadi kesalahan: " + data.response_message);
            }

        } catch (error) {
            console.error('Error saving department:', error);
            alert("Terjadi kesalahan saat menyimpan data!");
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Fungsi untuk mendapatkan tanggal dan waktu dalam format yang sesuai
        const getCurrentDateTime = () => {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
            const date = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            return `${year}-${month}-${date}T${hours}:${minutes}`;
        };

        // Mengisi nilai default
        const currentDateTime = getCurrentDateTime();
        document.getElementById('clockOut').value = currentDateTime;
        document.getElementById('dateAttendance').value = currentDateTime;
    });
</script>
@endsection
