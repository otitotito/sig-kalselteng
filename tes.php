<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Modal</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- <script>
    if (!localStorage.getItem("hideModal")) {
      Swal.fire({
        title: "SIG v.1.0",
        html: `
        <p>Apa yang baru?</p>
        <ul>
          <li>Perbaikan fitur <b>Pencarian</b></li>
        </ul>
      `,
        icon: "warning",
        showCancelButton: true,
        showConfirmButton: false,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ok, lanjut",
        cancelButtonText: "Jangan tampilkan lagi",
        allowOutsideClick: false,
        width: 325,
      }).then((result) => {
        if (result.dismiss === Swal.DismissReason.cancel) {
          localStorage.setItem("hideModal", "true");
        }
      });
    }

    function resetModal() {
      localStorage.removeItem("hideModal");
    }
  </script> -->

  <script>
    if (!sessionStorage.getItem("hideModal")) {
      showMyModal();
    }

    function showMyModal() {
      setTimeout(function() {

        Swal.fire({
          title: "Data terbaru antasena sedang dalam perbaikan",
          html: "Data yang tersedia merupakan data per tanggal<br><b>25 November 2023.</b>",
          icon: "info",
          showCancelButton: true,
          showConfirmButton: false,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Ok, lanjut",
          cancelButtonText: "Jangan tampilkan lagi",
          allowOutsideClick: false,
          width: 500,
        }).then((result) => {
          if (result.dismiss === Swal.DismissReason.cancel) {
            sessionStorage.setItem("hideModal", "true");
          }
        });
      }, 3000);
    }
  </script>

  <button onclick="resetModal()">Tampilkan Modal Lagi</button>
</body>

</html>