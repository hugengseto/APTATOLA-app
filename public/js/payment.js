$(document).ready(function () {
  // Simpan nilai yang dipilih sebelumnya sebelum inisialisasi Select2
  var selectedValueBeforeInit = $("#transaction_code").val();

  // Inisialisasi Select2
  $(".select2bs4").select2({
    theme: "bootstrap4",
  });

  // Menambahkan event listener untuk inputan dengan id 'bayar'
  $("#bayar").on("input", function () {
    // Mengambil nilai dari inputan 'totalBayar'
    var totalBayar = parseFloat($("#totalBayar").val());
    // Mengambil nilai yang dimasukkan oleh pengguna pada inputan 'bayar'
    var bayar = parseFloat($(this).val());

    // Menghitung kembalian
    var kembalian = bayar - totalBayar;

    // Menetapkan nilai kembalian ke inputan 'kembalian'
    $("#kembalian").val(kembalian); // Menampilkan kembalian dengan dua angka desimal
  });

  // Memeriksa apakah data atribut totalBayar ada
  var totalBayar = $("#totalBayar").data("total");
  if (totalBayar) {
    // Jika ada, isi nilai input dengan data tersebut
    $("#totalBayar").val(totalBayar);
  }

  // Tambahkan event listener Select2 untuk menangani perubahan
  $(".select2bs4").on("change", function () {
    // Ambil nilai yang dipilih
    var selectedValue = $(this).val();
    // Kirim permintaan AJAX ke server
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/transaction/getCustomerData/" + selectedValue, true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        // Parse response JSON dari server
        var data = JSON.parse(xhr.responseText);

        // Setel nilai elemen formulir lain sesuai dengan data yang diterima
        $("#customer_name").text(data.customer_name);
        $("#customer_whatsapp").text(data.customer_whatsapp);
        $("#dibuat").text(data.created_at);
        $("#kode_transaksi").text(data.transaction_code);
        $("#pengambilan").text(data.pengambilan);
        $("#jumlah").text(data.weight);
        $("#paket").text(data.package_name);
        $("#hari").text(data.duration);
        $("#harga").text(data.price);
        $(".total").text(data.total_payment);
        $("#status").text(data.tagihan);

        // Merubah value inputan totalBayar
        $("#ktransaksi").val(data.transaction_code);
        $("#totalBayar").val(data.total_payment);
        $("#tombol").val(data.tagihan);

        // Mengambil nilai dari inputan 'bayar'
        var bayar = parseFloat($("#bayar").val());

        // Menghitung kembalian
        var kembalian = bayar - data.total_payment;

        // Menetapkan nilai kembalian ke inputan 'kembalian'
        $("#kembalian").val(kembalian);
      } else {
        $("#customer_name").text("xxx");
        $("#customer_whatsapp").text("xxx");
        $("#dibuat").text("xxx");
        $("#kode_transaksi").text("xxx");
        $("#pengambilan").text("xxx");
        $("#jumlah").text("xxx");
        $("#paket").text("xxx");
        $("#hari").text("xxx");
        $("#harga").text("xxx");
        $(".total").text("xxx");
        $("#status").text("xxx");

        // Merubah value inputan totalBayar
        $("#ktransaksi").val("");
        $("#totalBayar").val("");
        $("#tombol").val("");
        $("#kembalian").val("");
      }
    };
    xhr.send();
  });

  // Ambil nilai yang disimpan di old('transaction_code') setelah inisialisasi Select2
  var selectedValue = "<?= old('transaction_code'); ?>";

  // Set nilai yang dipilih sebelumnya sebagai default untuk select
  $("#transaction_code").val(selectedValue);

  // Memilih kembali nilai yang dipilih sebelumnya setelah inisialisasi Select2 selesai
  $("#transaction_code").val(selectedValueBeforeInit).trigger("change");

  // Sembunyikan pesan kesalahan secara default
  $("#radioError").hide();

  // Menambahkan event listener untuk memeriksa pemilihan radio
  $("input[name='metodePembayaran']").on("change", function () {
    // Memeriksa apakah salah satu radio dipilih
    if ($("input[name='metodePembayaran']:checked").length === 0) {
      // Jika tidak ada yang dipilih, tampilkan pesan kesalahan
      $("#radioError").show();
    } else {
      // Jika salah satu radio dipilih, sembunyikan pesan kesalahan
      $("#radioError").hide();
    }
  });

  // Menambahkan event listener untuk mengirim formulir
  $("#paymentForm").submit(function () {
    // Memeriksa apakah salah satu radio dipilih saat formulir disubmit
    if ($("input[name='metodePembayaran']:checked").length === 0) {
      // Jika tidak ada yang dipilih, tampilkan pesan kesalahan
      $("#radioError").show();
      // Hentikan proses pengiriman formulir
      return false;
    }
  });
});
