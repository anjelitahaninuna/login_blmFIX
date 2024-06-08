<?php
  require "koneksi.php";
  require "session.php";

  // $today = date("Y-m-d");
  $query1 = mysqli_query($con, "SELECT id, img, title, tanggal, lokasi, waktu, CONCAT('Rp ', REPLACE(FORMAT(harga, 0), ',', '.'),',-') AS harga FROM jadwal_konser WHERE tanggal >= CURDATE() ORDER BY tanggal ASC LIMIT 3");
  $query2 = mysqli_query($con, "SELECT id, img, title, tanggal, lokasi, waktu, CONCAT('Rp ', REPLACE(FORMAT(harga, 0), ',', '.'),',-') AS harga FROM jadwal_konser WHERE tanggal >= CURDATE() ORDER BY tanggal ASC LIMIT 3 OFFSET 3");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OJINK</title>
    <link rel="icon" href="img/logo.png" />
    <link rel="stylesheet" href="halamanutama.css" />
  </head>

  <body>
    <header>
      <div class="logo1">
        <a href="#">
          <img src="img/logo.png" alt="logo" />
        </a>
      </div>
      <div class="website">
        <a href="#">
          <h1>OJINK</h1>
        </a>
      </div>
      <div class="cari">
        <input
          type="text"
          placeholder="Cari Event, Orkes, dll"
          class="inputcari"
        />
        <input type="date" class="inputcari" />
      </div>
      <div class="login">
        <a href="login.php">LOGIN</a>
        <br>
        <!-- ku buat untuk bantu liat jadi ga masuk ga sessionku -->
        <a href="logout.php">LOGOUT</a>
      </div>
    </header>
    <div class="banner">
      <h1 class="welcome">SELAMAT DATANG <?php  echo $_SESSION['username'];?>!</h1>
      <h1>PASUKAN OJINK</h1>
      <p>
        Pasukan Ojink adalah sebuah komunitas atau kelompok informal yang
        terdiri dari orang-orang yang gemar berjoget dan bernyanyi bersama
        dengan penuh semangat, terutama mengikuti iringan musik dangdut koplo
        atau campursari.
      </p>
      
    </div>
    <?php
      $artis = "Dinda Teratu";

      // Query untuk mengecek keberadaan artis
      $query_check = mysqli_query($con, "SELECT COUNT(*) as count FROM jadwal_konser WHERE artis LIKE '%$artis%'");
      if (!$query_check) {
          die("Query error: " . mysqli_error($con));
      }
      
      $row_check = mysqli_fetch_assoc($query_check);
      $artis_ada = $row_check['count'] > 0;
      
      // Jika artis ditemukan, ambil data konser
      $konser_data = [];
      if ($artis_ada) {
          $query_konser = mysqli_query($con, "SELECT id, img, title, tanggal, lokasi FROM jadwal_konser WHERE artis LIKE '%$artis%' AND tanggal >= CURDATE() ORDER BY tanggal LIMIT 3");
          if (!$query_konser) {
              die("Query error: " . mysqli_error($con));
          }
          $konser_data = mysqli_fetch_all($query_konser, MYSQLI_ASSOC);
      }
      
      // Menampilkan data konser jika artis ditemukan
      if ($artis_ada && !empty($konser_data)) {
          echo '<section class="rekomendasi">
              <h1>REKOMENDASI ORKES</h1>
              <div class="side">
                  <h2>ORKES POPULER!</h2>
                  <p>Kumpulan Orkes Populer yang menampilkan artis-artis terkenal</p>
              </div>
              <div class="halrek">';
      
          foreach ($konser_data as $konser) {
              echo '<div class="kotak">
                  <div class="poster">
                      <img src="img/' . $konser['img'] . '" alt="' . $konser['title'] . '" />
                  </div>
                  <div class="isi">
                      <a href="detail.php?id=' . $konser['id'] . '">
                          <h2>' . $konser['title'] . '</h2>
                      </a>
                      <table>
                          <tr>
                              <td>Tanggal</td>
                              <td>: ' . date('d F Y', strtotime($konser['tanggal'])) . '</td>
                          </tr>
                          <tr>
                              <td>Lokasi</td>
                              <td>: ' . $konser['lokasi'] . '</td>
                          </tr>
                      </table>
                  </div>
              </div>';
          }
      
          echo '</div>
          </section>';
      } else {
          echo "Data konser tidak ditemukan untuk artis '$artis'.";
      }
    ?>
    <section class="jadwal">
      <h1>JADWAL ORKES</h1>
      <div class="container-content">
        <?php
          while($data = mysqli_fetch_array($query1)){
        ?>
        <div class="pemaindor">
          <div class="kotak">
            <div class="poster">
              <img src="img/<?php echo $data['img']?>" alt="<?php echo $data['img']?>" />
            </div>
            <div class="isi">
              <h2><?php echo $data['title']?></h2>
              <table>
                <tr>
                  <td>Tanggal</td>
                  <td>: <?php echo date('d F Y', strtotime($data['tanggal'])) ?></td>
                </tr>
                <tr>
                  <td>Lokasi</td>
                  <td>: <?php echo $data['lokasi']?></td>
                </tr>
                <tr>
                  <td>Waktu</td>
                  <td>: <?php echo $data['waktu']?></td>
                </tr>
                <tr>
                  <td class="harga">Harga Mulai</td>
                  <td class="harga">: <?php echo $data['harga']?></td>
                </tr>
              </table>
              <div class="detail">
                <a href="detail.php?id=<?php echo $data['id']?>">Detail</a>
              </div>
            </div>
          </div>
        </div>
        <?php
          }
        ?>
      </div>
      <div class="container-content">
        <?php
          while($data2 = mysqli_fetch_array($query2)){
        ?>
        <div class="pemaindor">
          <div class="kotak">
            <div class="poster">
              <img src="img/<?php echo $data2['img']?>" alt="<?php echo $data2['img']?>" />
            </div>
            <div class="isi">
              <h2><?php echo $data2['title']?></h2>
              <table>
                <tr>
                  <td>Tanggal</td>
                  <td>: <?php echo date('d F Y', strtotime($data2['tanggal'])) ?></td>
                </tr>
                <tr>
                  <td>Lokasi</td>
                  <td>: <?php echo $data2['lokasi']?></td>
                </tr>
                <tr>
                  <td>Waktu</td>
                  <td>: <?php echo $data2['waktu']?></td>
                </tr>
                <tr>
                  <td class="harga">Harga Mulai</td>
                  <td class="harga">: <?php echo $data2['harga']?></td>
                </tr>
              </table>
              <div class="detail">
                <a href="detail.php?id=<?php echo $data2['id']?>">Detail</a>
              </div>
            </div>
          </div>
        </div>
        <?php
          }
        ?>
      </div>
      <div class="seemore">
        <a href="detail.html">Lihat Lainnya</a>
      </div>
    </section>
    <footer>
      <div class="footer1">
        <div class="footerkiri">
          <img class="logo" src="img/logo.png" alt=" logo" />
          <p>
            <b>Ojink</b> adalah platform online yang menyediakan layanan
            pembelian tiket untuk berbagai acara, seperti konser musik,
            festival, hajatan, dan happy party. Website ini didirikan pada tahun
            2024 oleh sekelompok pemuda yang ingin memudahkan masyarakat dalam
            mendapatkan tiket orkes favorit mereka.
          </p>
          <p>Sosial Media:</p>
          <div class="sosmed">
            <a href="https://www.tiktok.com/@info_orkes_pati"
              ><img src="img/tiktok.png" alt="tiktok"
            /></a>
            <a href="https://www.facebook.com/infoorkespati"
              ><img src="img/fb.png" alt="fb"
            /></a>
            <a href="https://www.instagram.com/infoorkespati/"
              ><img src="img/ig.png" alt="ig"
            /></a>
          </div>
        </div>
        <div class="footerkiri">
          <p><b>INFORMASI</b></p>
          <a href="#">
            <p>Syarat dan Ketentuan</p>
          </a>
          <a href="#">
            <p>Privasi</p>
          </a>
        </div>
      </div>
      <div class="copyright">
        <p>PT. Pasukan Ojink Indonesia (Ojink)</p>
        <p>&copy; 2024 Ojink. All Rights Reserved</p>
      </div>
    </footer>
  </body>
</html>
