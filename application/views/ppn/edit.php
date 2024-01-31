 <!-- Begin Page Content -->
 <div class="container-fluid">

     <!-- Page Heading -->
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
         <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
     </div>


     <?= $this->session->flashdata('no_faktur_exists') ?>

     <div class="card" style="width: 60%; margin-bottom: 100px">
         <div class="card-body">


             <form method="POST" action="<?= base_url('ppn/updateSettings') ?>" id="myForm" onsubmit="return confirmSubmit();">

                 <div class="form-group">
                     <label>PPN</label>
                     <input type="text" name="ppn" class="form-control" value="<?php echo $nilai_dari_database; ?>">
                     <?php echo form_error('ppn', '<div class="text-small text-danger"></div>') ?>
                 </div>
                 <button type="submit" class="btn btn-success">Submit</button>

             </form>


         </div>
     </div>
     <script>
         function confirmSubmit() {
             var confirmation = confirm("Apakah Anda yakin ingin update?");
             return confirmation;
         }
     </script>


 </div>
 </div>