<?php
defined('BASEPATH') or exit('No direct script access allowed');



class PPN extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Transaksi_model', 'transaksi');
        $this->load->model('seting_model', 'set');
    }

    public function index()
    {

        $data['title'] = "Rekap Data PPN";

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();



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

            // Create date objects for start and end dates
            $startDate = new DateTime("$tahun-$bulan-$startDay");
            $endDate = new DateTime("$tahun-$bulan-$endDay");

            // Format dates as needed (e.g., Y-m-d)
            $formattedStartDate = $startDate->format('Y-m-d');
            $formattedEndDate = $endDate->format('Y-m-d');

            // Use the date range in your SQL query
            $query = "SELECT * FROM data_transaksi WHERE data_transaksi.tanggal_pembelian BETWEEN '$formattedStartDate' AND '$formattedEndDate'";
        } else {
            $bulan = date('m');
            $tahun = date('Y');

            // Create the date range for the entire month
            $startDate = new DateTime("$tahun-$bulan-01");
            $endDate = new DateTime("$tahun-$bulan-30");

            // Format dates as needed (e.g., Y-m-d)
            $formattedStartDate = $startDate->format('Y-m-d');
            $formattedEndDate = $endDate->format('Y-m-t');

            // Use the date range for the entire month in your SQL query
            $query = "SELECT * FROM data_transaksi WHERE data_transaksi.tanggal_pembelian BETWEEN '$formattedStartDate' AND '$formattedEndDate'";
        }

        $data['ppn'] = $this->transaksi->get_data('data_transaksi')->result();
        $data['ppn'] = $this->db->query($query)->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('ppn/index', $data);
        $this->load->view('templates/footer');
    }

    public function cetakLaporan()
    {
        $data['title'] = "Cetak Laporan PPN";
        if ((isset($_GET['bulan']) && $_GET['bulan'] != '') && (isset($_GET['tahun']) && $_GET['tahun'] != '')) {
            $bulan = $_GET['bulan'];
            $tahun = $_GET['tahun'];
            $bulantahun = $tahun . '-' . $bulan;
        } else {
            $bulan = date('m');
            $tahun = date('Y');
            $bulantahun = $tahun . '-' . $bulan;
        }

        $query = "SELECT * FROM data_transaksi WHERE DATE_FORMAT(tanggal_pembelian, '%Y-%m') = ?";
        $data['catakLaporan'] = $this->db->query($query, array($bulantahun))->result();

        $imagePath = base_url('assets/img/logo.png');


        $this->load->helper('dompdf_helper');

        // Contoh tampilan HTML yang ingin Anda konversi ke PDF
        $html = $this->load->view('pdf_template', $data, true);

        // Panggil fungsi generate_pdf() dari helper Dompdf
        $pdf_content = generate_pdf($html, 'laporan' . '-' . $bulantahun . '.pdf');
        $this->output->set_output($pdf_content);
    }

    public function datalis()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Data Pajak";
        $data['transaksi'] = $this->transaksi->get_data('data_transaksi')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('ppn/Transaksi.php', $data);
        $this->load->view('templates/footer');
    }

    public function tambahData()
    {
        $data['title'] = "Add Data Pajak";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('ppn/add.php', $data);
        $this->load->view('templates/footer');
    }


    public function no_faktur_exists($no_faktur)
    {
        // Panggil model atau lakukan query database untuk memeriksa keberadaan no_faktur
        if ($this->transaksi->checkNoFakturExists($no_faktur)) {
            return FALSE; // Jika sudah ada, kembalikan FALSE
        } else {
            return TRUE; // Jika belum ada, kembalikan TRUE
        }
    }

    public function tambah()
    {
        $this->form_validation->set_rules('no_faktur', 'no Faktur', 'required|callback_no_faktur_exists');
        $this->form_validation->set_rules('tanggal_pembelian', 'tanggal pembelian', 'required');
        $this->form_validation->set_rules('supplier', 'supplier', 'required');
        $this->form_validation->set_rules('nama_barang', 'nama barang', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');

        // Memeriksa apakah no_faktur sudah ada di database
        if ($this->transaksi->checkNoFakturExists($this->input->post('no_faktur'))) {
            // Jika sudah ada, set pesan kesalahan validasi
            $this->form_validation->set_message('no_faktur_exists', 'No Faktur ini sudah ada.');
            $this->session->set_flashdata('no_faktur_exists', '<div class="alert alert-success" role="alert">No Faktur ini sudah ada.</div>');
            $valid = FALSE; // Atau gunakan variabel validasi sesuai kebutuhan Anda
        } else {
            $valid = TRUE; // Jika no_faktur belum ada di database, data valid
        }

        $nilai_dari_database = $this->set->getNilaiDariDatabase();


        if ($this->form_validation->run() == FALSE) {
            $this->tambahData();
        } else {
            $no_faktur = $this->input->post('no_faktur');
            $tanggal_pembelian = $this->input->post('tanggal_pembelian');
            $supplier      = $this->input->post('supplier');
            $nama_barang = $this->input->post('nama_barang');
            $harga = $this->input->post('harga');

            if ($harga < 2000000) {
                $ppn = 0;
            } else {
                $ppn = $harga * 100 / 110 * $nilai_dari_database;
            }

            $data = array(

                'no_faktur'          => $no_faktur,
                'tanggal_pembelian'  => $tanggal_pembelian,
                'supplier'           => $supplier,
                'nama_barang'        => $nama_barang,
                'harga'              => $harga,
                'ppn'                => $ppn,
            );



            $this->transaksi->insert_data($data, 'data_transaksi');
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
              Data berhasil ditambahkan!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>');
            redirect('ppn/datalis');
        }
    }

    public function settings()
    {
        $data['title'] = "Edit PPN";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Load model
        $this->load->model('seting_model');

        // Ambil nilai dari database
        $data['nilai_dari_database'] = $this->seting_model->getNilaiDariDatabase();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('ppn/edit.php', $data);
        $this->load->view('templates/footer');
    }

    public function updateSettings()
    {
        // Validasi form
        $this->form_validation->set_rules('ppn', 'PPN', 'required|numeric');

        if ($this->form_validation->run() == false) {
            // Validasi gagal, tampilkan kembali halaman edit dengan pesan kesalahan
            $this->settings();
        } else {
            // Validasi berhasil, lakukan pembaruan data
            $ppn = $this->input->post('ppn');

            $this->load->model('seting_model');
            // Panggil fungsi untuk melakukan pembaruan data
            $this->seting_model->updateData($ppn);

            // Redirect ke halaman settings setelah pembaruan data
            redirect('ppn/settings');
        }
    }
}
