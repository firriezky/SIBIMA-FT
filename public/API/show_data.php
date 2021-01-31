<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
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


    <?php
    require_once 'connect.php';
      if($connect){
        $kode_kelompok = $_GET["kode_kelompok"];
        $query_cek_jadwal = mysqli_query($connect,"SELECT a.nama,a.nim,a.kelas,b.kode ,c.nama as `mentor`,c.line_id as `line_mentor`,c.no_telp as `phone` from mentee a left join kelompok b on a.kelompok_id=b.id
        left join mentor c on c.id=b.mentor_id where b.kode='$kode_kelompok'");
        $get_info = mysqli_fetch_array($query_cek_jadwal);
        //WARNING : DONT DELETE !!!
        // echo "<strong>Kelompok : $get_info[3]</strong><br>";
        // echo "Mentor   : $get_info[4] <br>";
        // echo "Grup Line / Line Mentor : $get_info[5] <br>";
        // echo "Kontak Mentor : $get_info[6] <br>";


        }else{
        echo "<h1>Anda Belum Mendapat Kelompok";
        }
    
     ?>
   </div>
       </div>

    <div style="overflow-x:auto;margin:15px;" >
    <table id="tb_peserta" width="100%">
      <thead>
      <th>No</th>
        <th>Nama</th>
        <th>NIM</td>
        <th>KELAS</th>
        <th>LINE</th>
      </thead>
      <tbody  id="tb_pesertax">
    <?php
    if($connect){
         $kode_kelompok = $_GET["kode_kelompok"];
        $sql_kelompok="SELECT a.nama,a.nim,a.kelas,b.kode,c.nama as `mentor`,c.line_id as `line_mentor`,c.no_telp as `phone` ,a.line_id as `line_mentee` from mentee a left join kelompok b on a.kelompok_id=b.id
        left join mentor c on c.id=b.mentor_id where b.kode='$kode_kelompok'";
      $call_database=mysqli_query($connect,$sql_kelompok);
    }else{
      echo "<p>Status Koneksi : Gagal Terhubung ke Database</p>";
      echo "<p>Silakan Coba Lagi Nanti</p>";
    }


    if($call_database){
      $no = 1;
    while ($fill_row = mysqli_fetch_row($call_database)) {
      echo "<tr><td>$no</td><td>$fill_row[0]</td><td>$fill_row[1]</td><td>$fill_row[2]</td><td>$fill_row[7]</tr>";
      $no++;
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
