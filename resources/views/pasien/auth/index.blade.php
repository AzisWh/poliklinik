<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pasien Auth</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.1.0/mdb.min.css" rel="stylesheet" />

    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <style>
        body {
            background-image: url('https://img.pikbest.com/backgrounds/20220119/medical-doctor-blue-minimalist-background_6244083.jpg!w700wp');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    @include('sweetalert::alert')

    <div class="container"
        style="background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
        <section class="rounded-lg p-3">

            <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="tab-login" data-mdb-pill-init href="#pills-login" role="tab"
                        aria-controls="pills-login" aria-selected="true">Login</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-register" data-mdb-pill-init href="#pills-register" role="tab"
                        aria-controls="pills-register" aria-selected="false">Register</a>
                </li>
            </ul>
            <!-- Pills navs -->

            <!-- Pills content -->
            <div class="tab-content">
                @if (session('message'))
                    <div class="alert alert-danger">
                        {{ session('message') }}
                    </div>
                @endif

                {{-- login --}}
                <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                    <form action="{{ route('pasien.login') }}" method="POST">
                        @csrf
                        <h4 class="text-center">Selamat datang, silahkan masukan akun anda</h4>

                        <!-- Name input -->
                        <div class="form-group mb-4">
                            <label for="loginName">Name</label>
                            <input type="text" class="form-control" id="loginName" name="name"
                                placeholder="Input Nama">
                        </div>

                        <!-- Nomor KTP input -->
                        <div class="form-group mb-4">
                            <label class="form-label" for="loginPassword">Nomor Ktp</label>
                            <input type="number" id="loginPassword" class="form-control" name="no_ktp"
                                placeholder="Input No Ktp" required />
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
                    </form>
                </div>

                {{-- register --}}
                <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="tab-register">
                    <form action="{{ route('pasien.register') }}" method="POST">
                        @csrf
                        <h4 class="text-center">Masukan data diri anda sesuai pada form inputan</h4>

                        <!-- Name input -->
                        <div class="form-group mb-4">
                            <label class="form-label" for="registerName">Name</label>
                            <input type="text" id="registerName" class="form-control" name="name" required />
                        </div>

                        <!-- Alamat input -->
                        <div class="form-group mb-4">
                            <label class="form-label" for="registerUsername">Alamat</label>
                            <input type="text" id="registerUsername" class="form-control" name="alamat" required />
                        </div>

                        <!-- No KTP input -->
                        <div class="form-group mb-4">
                            <label class="form-label" for="registerEmail">No Ktp</label>
                            <input type="number" id="registerEmail" class="form-control" name="no_ktp" required />
                        </div>

                        <!-- No HP input -->
                        <div class="form-group mb-4">
                            <label class="form-label" for="registerPassword">No Hp</label>
                            <input type="number" id="registerPassword" class="form-control" name="no_hp" required />
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mb-4">Sign up</button>
                    </form>
                </div>
            </div>
            <!-- Pills content -->
        </section>
    </div>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.1.0/mdb.umd.min.js"></script>
    {{-- @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: "{{ session('error') }}",
            });
        </script>
    @endif --}}
</body>

</html>
