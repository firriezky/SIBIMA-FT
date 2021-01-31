<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mentee Fakultas Teknik Telkom University</title>
  <link rel="stylesheet" href="CSS/style.css">
</head>

<body>

  <!-- <ul>
      <li><a class="active" href="#home">Home</a></li>
      <li><a href="#news">News</a></li>
      <li><a href="#contact">Peserta</a></li>
      <li><a href="registrasi.php">Daftar Bukber</a></li>
    </ul> -->

  <h1 class="header_style">Daftar Mentee Fakultas Teknik 2020</h1>

  <div class="info">
  <p>Khusus Mahasiswa Baru Jurusan Sistem Informasi, Teknik Elektro, Informatika PJJ dan Teknik Logistik </p>
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
    <table class=" table-responsive" id="tb_peserta" width="100%">
      <thead>
        <th>Kelas</th>
        <th>Nim</th>
        <th>Nama</td>
        <th>Jurusan</th>
        <th>Fakultas</th>
      </thead>
      <tbody id="tb_pesertax">


        <?php
        $connect = mysqli_connect('localhost', 'daniagung', 'IPM.or.id001@', 'sibimaft');
        if ($connect) {
          $call_database = mysqli_query($connect, "SELECT kelas,nim,nama,program_studi,fakultas FROM mentee");
        } else {
          echo "<p>Status Koneksi : Gagal Terhubung ke Database</p>";
          echo "<p>Silakan Coba Lagi Nanti</p>";
        }


        if ($call_database) {
          while ($fill_row = mysqli_fetch_row($call_database)) {
            echo "<tr><td>$fill_row[0]</td><td>$fill_row[1]</td><td>$fill_row[2]</td><td>$fill_row[3]</tr>";
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