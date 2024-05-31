$(document).ready(function () {
  // Fungsi untuk mengubah format tanggal dari 'Y-m-d H:i:s' menjadi 'd-m-Y H:i:s'
  function formatDate(dateString) {
    var date = new Date(dateString);
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();

    // Menambahkan nol di depan jika nilainya kurang dari 10
    if (day < 10) {
      day = "0" + day;
    }
    if (month < 10) {
      month = "0" + month;
    }
    if (hours < 10) {
      hours = "0" + hours;
    }
    if (minutes < 10) {
      minutes = "0" + minutes;
    }
    if (seconds < 10) {
      seconds = "0" + seconds;
    }

    return (
      day +
      "-" +
      month +
      "-" +
      year +
      " " +
      hours +
      ":" +
      minutes +
      ":" +
      seconds
    );
  }

  function formatDateDMY(dateString) {
    var date = new Date(dateString);
    var day = date.getDate();
    var month = date.getMonth() + 1; // Ingat bahwa bulan dimulai dari 0, sehingga perlu ditambahkan 1
    var year = date.getFullYear();

    // Menambahkan nol di depan jika nilainya kurang dari 10
    if (day < 10) {
      day = "0" + day;
    }
    if (month < 10) {
      month = "0" + month;
    }

    return day + "-" + month + "-" + year;
  }

  // Mengubah nilai total pembayaran menjadi format mata uang rupiah
  function formatRupiah(angka) {
    var reverse = angka.toString().split("").reverse().join(""),
      ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join(".").split("").reverse().join("");
    return "Rp " + ribuan;
  }

  // Inisialisasi dataTable dengan AJAX
  var table = $("#transaction-list-reports").DataTable({
    processing: true,
    serverSide: false,
    ajax: {
      url: "/transaction/getTransactionWithEmployeeData",
      type: "GET",
      dataSrc: function (json) {
        // Pastikan data yang diterima dalam format yang diharapkan
        if (json.data) {
          // Menghitung total pembayaran hanya untuk transaksi dengan status "Completed"
          var totalPayment = 0;
          json.data.forEach(function (row) {
            if (row.status === "Completed") {
              totalPayment += parseFloat(row.total_payment);
            }
            // Tentukan kelas CSS berdasarkan status
            if (row.status == "Completed") {
              row.status =
                "<span class='badge badge-success'>" + row.status + "</span>";
            } else if (row.status == "In Progress") {
              row.status =
                "<span class='badge badge-warning'>" + row.status + "</span>";
            } else {
              row.status =
                "<span class='badge badge-secondary'>" + row.status + "</span>";
            }
          });

          // Update elemen dengan ID "totalPayment" dengan nilai total pembayaran yang diformat sebagai rupiah
          $("#totalPayment").text(formatRupiah(totalPayment));

          return json.data;
        } else {
          console.error("Format respons tidak valid:", json);
          return [];
        }
      },
      error: function (xhr, error, thrown) {
        console.error("Kesalahan AJAX:", xhr, error, thrown);
        alert(
          "Terjadi kesalahan saat memuat data. Periksa konsol untuk detail lebih lanjut."
        );
      },
    },
    columns: [
      {
        data: null,
        render: function (data, type, row, meta) {
          return meta.row + 1; // Penomoran baris
        },
      },
      { data: "transaction_code" },
      { data: "customer_name" },
      { data: "customer_whatsapp" },
      { data: "package_name" },
      { data: "weight" },
      {
        data: "total_payment",
        render: function (data, type, row, mete) {
          return data ? formatRupiah(data) : "";
        },
      },
      {
        data: "created_at",
        render: function (data, type, row, mete) {
          return data ? formatDate(data) : "";
        },
      },
      {
        data: "pengambilan",
        render: function (data, type, row, mete) {
          return data ? formatDate(data) : "";
        },
      },
      { data: "status", className: "status-cell" },
      {
        data: "employee_name",
        render: function (data, type, row, meta) {
          return data ? data : "---"; // Mengembalikan data jika ada, jika tidak kembalikan "---"
        },
      },
    ],
    language: {
      emptyTable: "Tidak ada data yang tersedia dalam tabel",
    },
  });

  // Tambahkan event listener untuk mengubah tanggal
  $("#cetak").on("change", function () {
    // Reload tabel dengan parameter tanggal baru
    table.ajax
      .url(
        "/transaction/getTransactionWithEmployeeData?startDate=" +
          $("#startDate").val() +
          "&endDate=" +
          $("#endDate").val()
      )
      .load();

    // Mengubah format tanggal menjadi startDate - endDate
    var startDate = $("#startDate").val();
    var endDate = $("#endDate").val();
    var dateRange = formatDateDMY(startDate) + " ➡ " + formatDateDMY(endDate);

    // Update elemen dengan ID "dateRange" dengan rentang tanggal yang baru
    $("#dateRange").text(dateRange);
  });
});
