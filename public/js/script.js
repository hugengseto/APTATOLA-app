$(function () {
  $("#transaction-list")
    .DataTable({
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
    })
    .buttons()
    .container()
    .appendTo("#transaction-list_wrapper .col-md-6:eq(0)");
  $("#package").DataTable({
    paging: true,
    lengthChange: false,
    // searching: false,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
  });
  $("#employee").DataTable({
    paging: true,
    lengthChange: false,
    // searching: false,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
  });

  $("#description").summernote();

  $(".searchCustomer").select2();
  $(".select2bs4").select2({
    theme: "bootstrap4",
  });
});

//Preview photo change
function previewImg() {
  const photo = document.querySelector("#photo");
  const photoLabel = document.querySelector(".custom-file-label");
  const imgPreview = document.querySelector(".img-preview");

  photoLabel.textContent = photo.files[0].name;

  const photoFile = new FileReader();
  photoFile.readAsDataURL(photo.files[0]);

  photoFile.onload = function (e) {
    imgPreview.src = e.target.result;
  };
}

//SweetAlert2
// Ambil semua elemen dengan kelas swal
const swalElements = document.querySelectorAll(".swal");

// Loop melalui setiap elemen
swalElements.forEach((element) => {
  // Ambil nilai atribut data untuk setiap elemen
  const swalMessage = element.dataset.swalmessage;
  const swalTitle = element.dataset.swaltitle;
  const swalIcon = element.dataset.swalicon;

  // Periksa apakah ada pesan yang ditetapkan
  if (swalMessage) {
    // Tampilkan SweetAlert untuk setiap elemen
    Swal.fire({
      title: swalTitle ? swalTitle : "Successfully",
      text: swalMessage,
      icon: swalIcon ? swalIcon :"success",
    });
  }
});

// Menggunakan event listener untuk mengonfirmasi penghapusan
document.querySelectorAll(".delete-btn").forEach((btn) => {
  btn.addEventListener("click", function () {
    const id = this.dataset.id;

    // Menampilkan SweetAlert untuk konfirmasi penghapusan
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        // Jika pengguna menekan tombol "Yes", kirimkan formulir
        document.getElementById("deleteForm" + id).submit();
      }
    });
  });
});

//untuk menangani tambah data transaksi baru
$(function () {
  // Inisialisasi Select2 pada elemen select dengan kelas "laundry-package"
  var select = $(".laundry-package").select2();
  $(".select2bs4").select2({
    theme: "bootstrap4",
  });

  // Tetapkan nilai select ke data pertama
  var firstOption = select.find("option").first();
  firstOption.prop("selected", true);

  // Atur nilai input "price" dengan harga dari opsi pertama
  $("#price").val(firstOption.data("price"));

  // Menangani perubahan pada elemen select yang menggunakan Select2
  select.on("change", function () {
    // Mendapatkan nilai harga dari atribut data-price dari opsi yang dipilih
    var price = $(this).find("option:selected").data("price");

    // Mengatur nilai input "price" dengan harga yang dipilih
    $("#price").val(price);

    // Memanggil fungsi untuk menghitung total pembayaran
    calculateTotalPayment();
  });

  // Menangani perubahan pada input berat
  $("#weight").on("input", () => {
    // Memanggil fungsi untuk menghitung total pembayaran
    calculateTotalPayment();
  });

  // Fungsi untuk menghitung total pembayaran
  function calculateTotalPayment() {
    var weight = parseFloat($("#weight").val());
    var pricePerKg = parseFloat($("#price").val());

    // Memastikan berat dan harga per kg adalah angka yang valid
    if (!isNaN(weight) && !isNaN(pricePerKg)) {
      // Menghitung total pembayaran
      var totalPayment = weight * pricePerKg;

      // Mengatur nilai input "total_payment" dengan total pembayaran yang dihitung
      $("#total_payment").val(totalPayment);
    }
  }
});

// Menggunakan event listener untuk mengonfirmasi login
document.querySelectorAll(".logout-btn").forEach((btn) => {
  btn.addEventListener("click", function () {
    // Menghentikan default behavior dari tombol submit
    event.preventDefault();

    // Menampilkan SweetAlert untuk konfirmasi penghapusan
    Swal.fire({
      title: "Are you sure?",
      text: "You will end your session",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, Log Out!",
    }).then((result) => {
      if (result.isConfirmed) {
        // Jika pengguna menekan tombol "Yes", kirimkan formulir
        document.getElementById("logout").submit();
      }
    });
  });
});