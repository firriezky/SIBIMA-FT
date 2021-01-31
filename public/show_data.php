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


    <h1 class="header_style">Daftar Peserta Aktif</h1>
    <div class="wrap_info">
      <div class="info_jadwal" >
        <!-- <p style="text-align:center"><iframe src="https://www.youtube.com/embed/oJuGlqO85YI" align:center width="" height=""></iframe></p>  -->
        <div class="title_info_jadwal">
            <strong>Jadwal Buka Bersama Aktif/Tersedia :</strong>
        </div>

    <?php
    require_once 'connect.php';
      if($connect){
        $kode_kelompok = $_GET["kode_kelompok"];
        $sql_kelompok="SELECT a.nama,a.nim,a.kelas,b.kode ,c.nama as `mentor`,c.line_id as `line_mentor`,c.no_telp as `phone` from mentee a left join kelompok b on a.kelompok_id=b.id
        left join mentor c on c.id=b.mentor_id where b.kode='$kode_kelompok'";
          $query_cek_kelompok = mysqli_query($connect,$sql_kelompok);

        if($query_cek_kelompok){
        $get_info = mysqli_fetch_array($query_cek_kelompok);
        $id_buka_bersama = $get_info[0];

          echo "Kelompok : $get_info['kode'] <br>";
          echo "Mentor : $get_info['mentor'] <br>";
          echo "Line Mentor : $get_info['line_mentor'] <br>";
          echo "HP : $get_info['phone'] <br>";

        }else{
        echo "<h1>Anda Belum Mendapat Kelompok";
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
    </div>

    <div style="overflow-x:auto;margin:15px;" >
    <table id="tb_peserta" width="100%">
      <thead>
        <th style="font-family:montserrat">ID.</th>
        <th>Nama</td>
        <th>Username</th>
        <th>Kategori</th>
      </thead>
      <tbody  id="tb_pesertax">
    <?php
    if($connect){
         $kode_kelompok = $_GET["kode_kelompok"];
        $sql_kelompok="SELECT a.nama,a.nim,a.kelas,b.kode ,c.nama as `mentor`,c.line_id as `line_mentor`,c.no_telp as `phone` from mentee a left join kelompok b on a.kelompok_id=b.id
        left join mentor c on c.id=b.mentor_id where b.kode='$kode_kelompok'";
      $call_database=mysqli_query($connect,$sql_kelompok);
    }else{
      echo "<p>Status Koneksi : Gagal Terhubung ke Database</p>";
      echo "<p>Silakan Coba Lagi Nanti</p>";
    }


    if($call_database){
    while ($fill_row = mysqli_fetch_row($call_database)) {
      echo "<tr><td>$fill_row[0]</td><td>$fill_row[1]</td><td>$fill_row[2]</td><td>$fill_row[3]</tr>";
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
