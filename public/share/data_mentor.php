<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mentee Fakultas Teknik Telkom University</title>
  <link rel="stylesheet" href="CSS/style.css">
</head>

<body>

  <h1 class="header_style">Mentor Fakultas Teknik 2020</h1>

  <div class="text-center">
    <p>Jika nama anda belum terdaftar dibawah sila melapor di grup Line Mentor </p>
    <p>Silakan Login dan Mengupdate ID Line dan Nomor Telpon pada website dibawah <a href=""></a> </p>
    <p> <a href="https://sibima.badanmentoring.org/login">https://sibima.badanmentoring.org/login</a></p>
    <p>Username : NIM masing-masing , Password : mentor123 </p>
    <p><strong>Harap langsung ganti dan catat password baru</strong></p>

  </div>

  <div style="margin:15px; align:center">
    <form class="searchy">
      <div class="a-field search__field">
        <input type="text" id="query" onkeyup="search_table($('#query').val())" class="r-text-field a-field__input search__input" placeholder="Nim/Kelas/Jurusan" required>
        <label class="a-field__label-wrap search__hint" for="query">
          <span class="a-field__label">Cari Data</span>
        </label>
      </div>
    </form>
  </div>


  <div class="info_jadwal">
    <div style="text-align:center" class="">
      <div class="">
        <!-- jaja -->
      </div>
      <button class="btnTheme" type="button" id="btn_search" name="button">CARI</button>
      <button onClick="history.go(0);" class="btnTheme" id="btn_refresh" type="button" name="button">REFRESH</button>
    </div>
  </div>

  <div style="overflow-x:auto;margin:15px;">
    <table id="tb_peserta" width="100%">
      <thead>
        <th>Nim</th>
        <th>Nama</td>
        <th>Fakultas</th>
        <th>Line_ID</th>
        <th>Telp_No</th>

       

      </thead>
      <tbody id="tb_pesertax">


        <?php
        $connect = mysqli_connect('localhost', 'daniagung', 'IPM.or.id001@', 'sibimaft');
        if ($connect) {
          $call_database = mysqli_query($connect, "SELECT nim,nama,fakultas,line_id,no_telp FROM mentor");
        } else {
          echo "<p>Status Koneksi : Gagal Terhubung ke Database</p>";
          echo "<p>Silakan Coba Lagi Nanti</p>";
        }


        if ($call_database) {
          while ($fill_row = mysqli_fetch_row($call_database)) {
            echo "<tr><td>$fill_row[0]</td><td>$fill_row[1]</td><td>$fill_row[2]</td><td>$fill_row[3]</td><td>$fill_row[4]</td></tr>";
          }
        } else {
          echo "Gagal Terhubung Dengan Server";
        }
        ?>
      </tbody>
    </table>
  </div>

  <script>
    $(document).ready(function() {
      $('#query').keyup(function() {
        search_table($('#query').val());
      });
      $('#btn_search').click(function() {
        search_table($('#query').val());
      });
      $('#btn_reset').click(function() {
        search_table('');
        $('#query').val('');
      });

      function search_table(value) {
        $('#tb_pesertax tr').each(function() {
          var found = 'false';
          $(this).each(function() {
            if ($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0) {
              found = 'true';
            }
          });
          if (found == 'true') {
            $(this).show();
          } else {
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