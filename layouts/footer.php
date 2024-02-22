<script src="<?= base_url(); ?>/data/ILOK_KALTENG.js"></script>
<script src="<?= base_url(); ?>/data/IUP_KALTENG.js"></script>
<script src="<?= base_url(); ?>/data/PETA_ARL.js"></script>
<!-- <script src="<?= base_url(); ?>/data/PETA_DIV.js"></script>
<script src="<?= base_url(); ?>/data/PETA_EST.js"></script>
<script src="<?= base_url(); ?>/data/PETA_IZN.js"></script>
<script src="<?= base_url(); ?>/data/PETA_KWS.js"></script>
<script src="<?= base_url(); ?>/data/PETA_RKT.js"></script> -->
<script src="<?= base_url(); ?>/data/PETA_TNM.js"></script>

<script src="<?= base_url(); ?>/assets/js/script.js"></script>

<script>
    if (!sessionStorage.getItem("hideModal")) {
        showMyModal();
    }

    function showMyModal() {
        setTimeout(function() {

            const subSIG = 'Sistem Informasi Geografis';
            const versionSIG = '(v.1.1 beta 1)';
            const updateBLN = new Date().toLocaleString('default', {
                month: 'long'
            });
            const updateTHN = new Date().getFullYear();

            Swal.fire({
                title: `SIG <hr><h5>${subSIG}</h5><h6>${versionSIG}</h6><hr>`,
                showClass: {
                    popup: `animate__animated`
                },
                html: `
                <p class="swal2-p">Apa yang baru?</p>
                <p class="swal2-minip">${updateBLN}, ${updateTHN}</p>
                <ul class="swal2-ul">                
                <li>Perbaikan fitur <span>Pencarian</span></li>
                <li>Penambahan fitur <span>Fullscreen</span></li>
                <li>Penambahan beberapa data jenis, antara lain: <span>AREAL, DIVISI, ESTATE, IZIN, KAWASAN, RKT, TANAM</span></li>
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
                width: 375,
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.cancel) {
                    sessionStorage.setItem("hideModal", "true");
                }
            });
        }, 3000);
    }
</script>



</body>

</html>