@extends('master')
@section('content')
<div class="layout-px-spacing">

    <div class="middle-content container-xxl p-0">

        <!-- BREADCRUMB -->
        <div class="page-meta">
            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Profile</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ubah Password</li>
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
                                        <h6 class="">Password</h6>
                                        <div class="row">
                                            <div class="col-lg-11 mx-auto">
                                                <div class="row">

                                                    <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
                                                        <div class="form">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="fullName">Password Lama</label>
                                                                        <input type="password" class="form-control mb-3" name="password" id="password" placeholder="Masukan password lama" >
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="profession">Password Baru</label>
                                                                        <input type="password" class="form-control mb-3" name="new_password" id="new_password" placeholder="Masukan Password Baru">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-12 mt-1">
                                                                    <div class="form-group text-end">
                                                                        <button type="button" onclick="updatePassword('{{$id}}')" class="btn btn-secondary">Save</button>
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


    async function updatePassword(id) {
        try {
            const token = `{{ Session::get('token') }}`;
            
            // Ambil data dari form
            const password = document.querySelector('input[name="password"]').value;
            const new_password = document.querySelector('input[name="new_password"]').value;
            console.log(id);
            // Validasi input
            if (!password || !new_password) {
                alert("Semua field harus diisi!");
                return;
            }

            // Data yang akan dikirim ke API
            const payload = {
                password: password,
                new_password: new_password,
            };

            // Kirim request ke API dengan metode POST
            const response = await fetch(`http://127.0.0.1:8100/api/user-password/update/${id}`, {
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
                alert("Password berhasil diubah!");
                window.location.href="/profile"
            } else {
                alert("Terjadi kesalahan: " + data.response_message);
            }

        } catch (error) {
            console.error('Error saving password:', error);
            alert("Terjadi kesalahan saat menyimpan data!");
        }
    }
</script>
@endsection