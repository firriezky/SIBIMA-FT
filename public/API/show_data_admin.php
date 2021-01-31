<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peserta Bukber</title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="CSS/style.css">
  </head>
  <body>

    <!-- <ul>
      <li><a class="active" href="#home">Home</a></li>
      <li><a href="#news">News</a></li>
      <li><a href="#contact">Peserta</a></li>
      <li><a href="registrasi.php">Daftar Bukber</a></li>
    </ul> -->


    <h1 class="header_style">Dashboard Manage Peserta Aktif</h1>
    <div class="wrap_info">
      <div class="info_jadwal" >
        <div class="title_info_jadwal">
            <strong>Jadwal Buka Bersama Aktif/Tersedia :</strong>
        </div>
    <?php
      $connect = mysqli_connect('localhost:3307','root','','bukber');
      if($connect){
        $query_cek_jadwal = mysqli_query($connect,"SELECT * from acara_bukber where status = 'tersedia' LIMIT 1");
        if($query_cek_jadwal){
        $get_jadwal = mysqli_fetch_row($query_cek_jadwal);
        $id_buka_bersama = $get_jadwal[0];
        $cek_jumlah_peserta=mysqli_query($connect,"SELECT COUNT(*) FROM pesertabukber where id_bukber='$id_buka_bersama'");
        $cek_akhwat=mysqli_query($connect,"SELECT COUNT(*) FROM pesertabukber where id_bukber='$id_buka_bersama' AND jenis_kelamin='Ikhwan'");
        $cek_ikhwan=mysqli_query($connect,"SELECT COUNT(*) FROM pesertabukber where id_bukber='$id_buka_bersama' AND jenis_kelamin='Akhwat'");
        $akhwat_no=mysqli_query($connect,"SELECT COUNT(*) FROM pesertabukber where id_bukber='$id_buka_bersama' AND jenis_kelamin='Ikhwan' AND status_ambil='Belum Diambil'");
        $ikhwan_no=mysqli_query($connect,"SELECT COUNT(*) FROM pesertabukber where id_bukber='$id_buka_bersama' AND jenis_kelamin='Akhwat' AND status_ambil='Belum Diambil'");

          $get_peserta=mysqli_fetch_row($cek_jumlah_peserta);
          $get_ikhwan=mysqli_fetch_row($cek_akhwat);
          $get_akhwat=mysqli_fetch_row($cek_ikhwan);
          $get_remain_ikhwan=mysqli_fetch_row($ikhwan_no);
          $get_remain_akhwat=mysqli_fetch_row($akhwat_no);
          echo "ID Bukber : $get_jadwal[0] <br>";
  echo "Kategori Kegiatan : $get_jadwal[1] <br>";
          echo "Kategori Kegiatan : $get_jadwal[1] <br>";
          echo "Tanggal : $get_jadwal[2] <br>";
          echo "Menu Makanan : $get_jadwal[5] <br>";
          echo "Total Peserta : $get_peserta[0] Orang <br>";
          echo "Peserta Ikhwan : $get_ikhwan[0] Orang <br>" ;
          echo "Peserta Akhwat : $get_akhwat[0] Orang <br>";
          echo "Jumlah Ikhwan Belum Mengambil Makanan : $get_remain_ikhwan[0] Orang <br>" ;
          echo "Jumlah Ikhwan Belum Mengambil Makanan : $get_remain_akhwat[0] Orang <br>" ;
        }else{
        echo "<h1>Belum Tersedia Jadwal Buka Bersama";
        }
        }else{
          echo "<p>Status Koneksi : Gagal Terhubung ke Database</p>";
          echo "<p>Silakan Coba Lagi Nanti</p>";
        }
     ?>
   </div>
       </div>
    <div style="margin:15px; align:center">
      <form class="searchy">
        <div class="a-field search__field">
          <input type="text" id="query" class="r-text-field a-field__input search__input" placeholder="Username/Nama" required>
          <label class="a-field__label-wrap search__hint" for="query">
            <span class="a-field__label">Cari Peserta</span>
          </label>
        </div>
      </form>
    </div>
    <div class="info_jadwal">
      <div style="text-align:center"class="">
        <div class="">
<!-- jaja -->
        </div>
      <button class="btnTheme" type="button" id="btn_search" name="button">CARI</button>
      <button class="btnTheme" id="btn_reset" type="button" name="button">RESET</button>
      <button onClick="history.go(0);" class="btnTheme" id="btn_refresh" type="button" name="button">REFRESH</button>
    </div>
      <p text-align:center><em>Swipe kanan pada table untuk melihat password dan status ambil</em></p>
  <?php  echo "Jumlah Ikhwan Belum Mengambil Makanan : <br> $get_remain_ikhwan[0] Orang <br>" ;
          echo "Jumlah Ikhwan Belum Mengambil Makanan : <br> $get_remain_akhwat[0] Orang <br>" ; ?>

    </div>

    <div style="overflow-x:auto;margin:15px;" >
    <table id="tb_peserta" width="100%">
      <thead>
        <th style="font-family:montserrat">ID.</th>
        <th>Nama</td>
        <th>Username</th>
        <th>Kategori</th>
        <th>Password</th>
        <th>Status Ambil</th>
      </thead>
      <tbody  id="tb_pesertax">
    <?php
    $connect = mysqli_connect('localhost:3307','root','','bukber');
    if($connect){
      $call_database=mysqli_query($connect,"SELECT a.id_peserta,a.nama,a.username,a.jenis_kelamin , a.password , a.status_ambil
        FROM pesertabukber a join acara_bukber b on a.id_bukber=b.id where b.status = 'tersedia'");
    }else{
      echo "<p>Status Koneksi : Gagal Terhubung ke Database</p>";
      echo "<p>Silakan Coba Lagi Nanti</p>";
    }
    $get_peserta=mysqli_fetch_row($cek_jumlah_peserta);
    $get_ikhwan=mysqli_fetch_row($cek_akhwat);
    $get_akhwat=mysqli_fetch_row($cek_ikhwan);


    if($call_database){
    while ($fill_row = mysqli_fetch_row($call_database)) {
      echo "<tr><td>$fill_row[0]</td><td>$fill_row[1]</td><td>$fill_row[2]</td><td>$fill_row[3]</td><td>$fill_row[4]</td><td>$fill_row[5]</td></tr>";
    }
      }else{
        echo "Gagal Terhubung Dengan Server";
      }
    ?>
        </tbody>
      </table>
    </div>

    <script>
         $(document).ready(function(){
              $('#btn_search').click(function(){
                   search_table($('#query').val());
              });
              $('#btn_reset').click(function(){
                   search_table('');
                   $('#query').val('');
              });
              function search_table(value){
                   $('#tb_pesertax tr').each(function(){
                        var found = 'false';
                        $(this).each(function(){
                             if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0)
                             {
                                  found = 'true';
                             }
                        });
                        if(found == 'true')
                        {
                             $(this).show();
                        }
                        else
                        {
                             $(this).hide();
                        }
                   });
              }
         });
    </script>

  </body>
  <footer>
  </footer>
</html>
