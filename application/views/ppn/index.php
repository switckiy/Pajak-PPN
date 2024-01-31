 <!-- Begin Page Content -->
 <div class="container-fluid">

     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
         <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
     </div>

     <div class="card">
         <div class="card-header bg-primary text-white">
             Laporan Data PPN
         </div>
         <div class="card-body">
             <form class="form-inline">
                 <div class="form-group mb-2">
                     <label for="startDate" class="">Tanggal Awal : </label>
                     <select class="form-control ml-2" name="startDay">
                         <option value="">--Pilih Tanggal--</option>
                         <?php
                            // Loop to generate options for days
                            for ($day = 1; $day <= 31; $day++) {
                                echo '<option value="' . sprintf("%02d", $day) . '">' . sprintf("%02d", $day) . '</option>';
                            }
                            ?>
                     </select>
                 </div>
                 <div class="form-group mb-2 ml-3">
                     <label for="endDate">Tanggal Akhir : </label>
                     <select class="form-control ml-2" name="endDay">
                         <option value="">--Pilih Tanggal--</option>
                         <?php
                            // Loop to generate options for days
                            for ($day = 1; $day <= 31; $day++) {
                                echo '<option value="' . sprintf("%02d", $day) . '">' . sprintf("%02d", $day) . '</option>';
                            }
                            ?>
                     </select>
                 </div>
                 <div class="form-group mb-2 ml-5">
                     <label for="staticEmail2" class="">Bulan : </label>
                     <select class="form-control ml-2" name="bulan">
                         <option value="">--Pilih Bulan--</option>
                         <option value="01">Januari</option>
                         <option value="02">Februari</option>
                         <option value="03">Maret</option>
                         <option value="04">April</option>
                         <option value="05">Mei</option>
                         <option value="06">Juni</option>
                         <option value="07">Juli</option>
                         <option value="08">Agustus</option>
                         <option value="09">September</option>
                         <option value="10">Oktober</option>
                         <option value="11">November</option>
                         <option value="12">Desember</option>
                     </select>
                 </div>
                 <div class="form-group mb-2 ml-5">
                     <label for="staticEmail2">Tahun : </label>
                     <select class="form-control ml-2" name="tahun">
                         <option value="">--Pilih Tahun--</option>
                         <?php $tahun = date('Y');
                            for ($i = 2023; $i < $tahun + 5; $i++) { ?>
                             <option value="<?= $i ?>"><?= $i ?></option>
                         <?php } ?>
                     </select>
                 </div>

                 <?php
                    if ((isset($_GET['startDay']) && $_GET['startDay'] != '') &&
                        (isset($_GET['endDay']) && $_GET['endDay'] != '') &&
                        (isset($_GET['bulan']) && $_GET['bulan'] != '') &&
                        (isset($_GET['tahun']) && $_GET['tahun'] != '')
                    ) {

                        $startDay = $_GET['startDay'];
                        $endDay = $_GET['endDay'];
                        $bulan = $_GET['bulan'];
                        $tahun = $_GET['tahun'];

                        $startDate = $tahun . '-' . $bulan . '-' . $startDay;
                        $endDate = $tahun . '-' . $bulan . '-' . $endDay;

                        $bulantahun = $tahun . '-' . $bulan . '%';
                    } else {
                        $startDay = date('d');
                        $endDay = date('d');
                        $bulan = date('m');
                        $tahun = date('Y');

                        $startDate = $tahun . '-' . $bulan . '-' . $startDay;
                        $endDate = $tahun . '-' . $bulan . '-' . $endDay;

                        $bulantahun = $tahun . '-' . $bulan . '%';
                    }

                    ?>

                 <!-- Rest of your code -->

                 <button type="submit" class="btn btn-primary mb-2 ml-auto"><i class="fas fa-eye"></i> Tampilkan Data</button>
                 <?php if (count($ppn) > 0) { ?>
                     <a href="<?= base_url('ppn/cetakLaporan?startDay=' . $startDay . '&endDay=' . $endDay . '&bulan=' . $bulan . '&tahun=' . $tahun); ?>" class="btn btn-success mb-2 ml-3"><i class="fas fa-print"></i> Cetak Laporan</a>
                 <?php } else { ?>
                     <button type="button" class="btn btn-success mb-2 ml-3" data-toggle="modal" data-target="#"><i class="fas fa-print"></i> Cetak Laporan</button>
                 <?php } ?>
             </form>
         </div>
     </div>
     <?php
        if (
            (isset($_GET['startDay']) && $_GET['startDay'] != '') &&
            (isset($_GET['endDay']) && $_GET['endDay'] != '') &&
            (isset($_GET['bulan']) && $_GET['bulan'] != '') &&
            (isset($_GET['tahun']) && $_GET['tahun'] != '')
        ) {
            $startDay = $_GET['startDay'];
            $endDay = $_GET['endDay'];
            $bulan = $_GET['bulan'];
            $tahun = $_GET['tahun'];
            $bulantahun = $startDay . $endDay . $tahun . $bulan;

            // Construct the full date strings with leading zeros for day, month, and year
            $startDate = sprintf("%04d-%02d-%02d", $tahun, $bulan, $startDay);
            $endDate = sprintf("%04d-%02d-%02d", $tahun, $bulan, $endDay);
        } else {
            $startDay = date('d');
            $endDay = date('d');
            $bulan = date('m');
            $tahun = date('Y');
            $bulantahun = $startDay . $endDay . $tahun . $bulan;

            // Construct the full date strings for today with leading zeros
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d');
        }
        ?>


     <div class="alert alert-info">
         Menampilkan Data PPN Bulan: <span class="font-weight-bold"><?= $bulan ?></span> Tahun: <span class="font-weight-bold"><?= $tahun ?></span>
     </div>

     <?php
        $jml_data = count($ppn);
        if ($jml_data > 0) { ?>

         <table class="table table-bordered table striped">
             <tr>
                 <th class="text-center">No</th>
                 <th class="text-center">No Faktur</th>
                 <th class="text-center">Tanggal Pembelian</th>
                 <th class="text-center">Supplier</th>
                 <th class="text-center">Nama Barang</th>
                 <th class="text-center">Harga</th>
                 <th class="text-center">PPN 11%</th>
                 <th class="text-center">Total</th>
             </tr>

             <?php $no = 1;
                foreach ($ppn as $t) : ?>

                 <tr>
                     <td>
                         <center><?= $no++ ?></center>
                     </td>
                     <td>
                         <center><?= $t->no_faktur ?></center>
                     </td>
                     <td>
                         <center><?= date('d-m-y', strtotime($t->tanggal_pembelian)) ?></center>
                     </td>
                     <td>
                         <center><?= $t->supplier ?></center>
                     </td>
                     <td>
                         <center><?= $t->nama_barang ?></center>
                     </td>
                     <td>
                         <center>Rp. <?= number_format($t->harga, 0, ',', '.') ?></center>
                     </td>
                     <td>
                         <center>Rp. <?= number_format($t->ppn, 0, ',', '.') ?></center>
                     </td>
                     <td>
                         <center>Rp. <?= number_format($t->ppn + $t->harga, 0, ',', '.') ?></center>
                     </td>

                 </tr>
             <?php endforeach; ?>
         </table>

     <?php } else { ?>
         <span class="badge badge-denger"><i class="fas fa-info-circle"></i>
             Data Masih Kosong, silahkan tambah data perhitungan pajak terlebih dahulu pada bulan dan tahun yang Anda pilih!</span>
     <?php } ?>


 </div>
 </div>