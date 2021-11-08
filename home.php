<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "db_sekolah";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
// if(!$koneksi){//cek koneksi
//     die("Tidak bisa terkoneksi ke database");

// }else{
//     echo "Koneksi berhasil";
// }
$nis            = "";
$nama           = "";
$jenis_kelamin  = "";
$alamat         = "";
$jurusan        = "";
$sukses         = "";
$error          = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id         = $_GET['id'];
    $sql1       = "DELETE FROM buku WHERE id_siswa = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error  = "Gagal melakukan delete data";
    }
}

if ($op == 'edit') { //untuk edit/update
    $id             = $_GET['id'];
    $sql1           = "SELECT * FROM buku WHERE id_siswa = '$id'";
    $q1             = mysqli_query($koneksi, $sql1);
    $r1             = mysqli_fetch_array($q1);
    $nis            = $r1['nis'];
    $nama           = $r1['nama_siswa'];
    $jenis_kelamin  = $r1['jenis_kelamin'];
    $alamat         = $r1['alamat'];
    $jurusan        = $r1['nama_jurusan'];

    if ($nis == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) { //untuk create
    $nis            = $_POST['nis'];
    $nama           = $_POST['nama'];
    $jenis_kelamin  = $_POST['jk'];
    $alamat         = $_POST['alamat'];
    $jurusan        = $_POST['jurusan'];

    if ($nis && $nama && $jenis_kelamin && $alamat && $jurusan) {
        if ($op == 'edit') { //untuk update
            $sql1       = "UPDATE buku SET nis = '$nis', nama_siswa='$nama', jenis_kelamin= '$jenis_kelamin', alamat='$alamat', nama_jurusan='$jurusan' WHERE id_siswa='$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into buku(nis,nama_siswa,jenis_kelamin,alamat,nama_jurusan) values ('$nis', '$nama', '$jenis_kelamin', '$alamat', '$jurusan')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silahkan masukkan semua data";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px
        }
    </style>


</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-info">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">SMK Telkom Purwokerto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                    </li>
                   
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <center>
        <h1>-->Data Siswa<--</h1>
    </center>
    <br>
    <div class="mx-auto">
        <!-- untuk memassukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nis" class="col-sm-2- col-form-label">NIS</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nis" name="nis" value="<?php echo $nis ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="col-sm-2- col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jk" class="col-sm-2- col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jk" id="jk">
                                <option value="">--Pilih Gender--</option>
                                <option value="laki" <?php if ($jenis_kelamin == "laki") echo "selected" ?>>Laki-laki</option>
                                <option value="perempuan" <?php if ($jenis_kelamin == "perempuan") echo "selected" ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="col-sm-2- col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jurusan" class="col-sm-2- col-form-label">Jurusan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jurusan" id="jurusan">
                                <option value="">--Pilih Jurusan--</option>
                                <option value="rpl" <?php if ($jurusan == "rpl") echo "selected" ?>>Rekayasa Perangkat Lunak</option>
                                <option value="tkj" <?php if ($jurusan == "tkj") echo "selected" ?>>Teknik Komputer dan Jaringan</option>
                                <option value="tja" <?php if ($jurusan == "tja") echo "selected" ?>>Teknik Jaringan Akses</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>


        <!-- untuk Mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Siswa
            </div>
            <div class="card-body">
                <nav class="navbar navbar-light bg-light">
                    <div class="container-fluid">
                        <form class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
                            <button class="btn btn-outline-info" type="submit" name="cari">Search</button>
                        </form>
                    </div>
                </nav>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">NIS</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Jurusan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2   = "SELECT * FROM buku ORDER BY id_siswa desc";
                        if(isset($_POST['cari'])){
                            $search = $_POST['search'];
                            $sql2   = mysqli_query($koneksi, "SELECT * FROM buku WHERE nama_siswa LIKE '%$search%'");
                        }
                        $q2    = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id             = $r2['id_siswa'];
                            $nis            = $r2['nis'];
                            $nama           = $r2['nama_siswa'];
                            $jenis_kelamin  = $r2['jenis_kelamin'];
                            $alamat         = $r2['alamat'];
                            $jurusan        = $r2['nama_jurusan'];

                        ?>
                            <tr>
                                <th><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nis ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $jenis_kelamin ?></td>
                                <td scope="row"><?php echo $alamat ?></td>
                                <td scope="row"><?php echo $jurusan ?></td>
                                <td scope="row">
                                    <a href="home.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="home.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin ingin delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>

                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>

</html>