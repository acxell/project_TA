{{-- JS Files for Templating --}}

<script src="{{ asset('template/assets/static/js/initTheme.js') }}"></script>

<script src="{{ asset('template/assets/static/js/components/dark.js') }}"></script>
<script src="{{ asset('template/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>


<script src="{{ asset('template/assets/compiled/js/app.js') }}"></script>

<!-- Need: Apexcharts -->
<script src="{{ asset('template/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('template/assets/static/js/pages/dashboard.js') }}"></script>

<!-- Simple Database -->
<script src="{{ asset('template/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
<script src="{{ asset('template/assets/static/js/pages/simple-datatables.js') }}"></script>

<!-- Select Element -->
<script src="{{ asset('template/assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
<script src="{{ asset('template/assets/static/js/pages/form-element-select.js') }}"></script>

{{-- script sidebar --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const items = document.querySelectorAll('.sidebar-item');

        // Menandai item sidebar yang sesuai dengan URL halaman saat ini sebagai aktif
        const currentURL = window.location.href;
        items.forEach(item => {
            const link = item.querySelector('a.sidebar-link');
            if (link && link.href === currentURL) {
                item.classList.add('active');
            }

            item.addEventListener('click', function() {
                // Hapus kelas 'active' dari semua item
                items.forEach(i => i.classList.remove('active'));

                // Tambahkan kelas 'active' pada item yang diklik
                this.classList.add('active');
            });
        });
    });
</script>

<script>
    //paging Form
    /*
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 3;

    function showStep(step) {
        for (let i = 1; i <= totalSteps; i++) {
            document.getElementById(`step-${i}`).style.display = (i === step) ? 'block' : 'none';
        }
    }

    document.getElementById('next-step-1').addEventListener('click', function() {
        currentStep++;
        showStep(currentStep);
    });

    document.getElementById('prev-step-2').addEventListener('click', function() {
        currentStep--;
        showStep(currentStep);
    });

    document.getElementById('next-step-2').addEventListener('click', function() {
        currentStep++;
        showStep(currentStep);
    });

    document.getElementById('prev-step-3').addEventListener('click', function() {
        currentStep--;
        showStep(currentStep);
    });

    showStep(currentStep);
});
*/
</script>

<script>
    // =================== Outcome Section ===================
    let outcomeCount = 1;
    document.getElementById('add-outcome').addEventListener('click', function() {
        outcomeCount++;
        const outcomeWrapper = document.getElementById('outcome-wrapper');
        const newOutcomeGroup = document.createElement('div');
        newOutcomeGroup.classList.add('form-group', 'd-flex');
        newOutcomeGroup.id = 'outcome-group-' + outcomeCount;
        newOutcomeGroup.innerHTML = `
        <input type="text" name="outcomes[]" class="form-control" placeholder="Outcome">
        <button type="button" class="btn btn-danger ms-2 remove-outcome">Delete</button>`;
        outcomeWrapper.appendChild(newOutcomeGroup);
    });

    document.getElementById('outcome-wrapper').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-outcome')) {
            event.target.closest('.form-group').remove();
        }
    });

    // =================== Indikator Section ===================
    let indikatorCount = 1;
    document.getElementById('add-indikator').addEventListener('click', function() {
        indikatorCount++;
        const indikatorWrapper = document.getElementById('indikator-wrapper');
        const newIndikatorGroup = document.createElement('div');
        newIndikatorGroup.classList.add('form-group', 'd-flex');
        newIndikatorGroup.id = 'indikator-group-' + indikatorCount;
        newIndikatorGroup.innerHTML = `
        <input type="text" name="indikators[]" class="form-control" placeholder="Indikator">
        <button type="button" class="btn btn-danger ms-2 remove-indikator">Delete</button>`;
        indikatorWrapper.appendChild(newIndikatorGroup);
    });

    document.getElementById('indikator-wrapper').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-indikator')) {
            event.target.closest('.form-group').remove();
        }
    });

    // =================== Aktivitas Section ===================
    let aktivitasCount = 1;
    document.getElementById('add-aktivitas').addEventListener('click', function() {
        aktivitasCount++;
        const aktivitasWrapper = document.getElementById('aktivitas-wrapper');

        const newAktivitasGroup = document.createElement('div');
        newAktivitasGroup.classList.add('row', 'align-items-center', 'mb-3');
        newAktivitasGroup.id = 'aktivitas-group-' + aktivitasCount;

        newAktivitasGroup.innerHTML = `
        <div class="col-md-2 col-12">
            <label for="waktu_aktivitas">Waktu Aktivitas</label>
            <input type="date" name="waktu_aktivitas[]" class="form-control" placeholder="mm/dd/yyyy">
        </div>

        <div class="col-md-6 col-12">
            <label for="penjelasan">Penjelasan</label>
            <textarea name="penjelasan[]" class="form-control" placeholder="Penjelasan" rows="1"></textarea>
        </div>

        <div class="col-md-3 col-12">
            <label for="kategori">Kategori</label>
            <select class="choices form-select" name="kategori[]">
                <option value="Persiapan">Persiapan</option>
                <option value="Pelaksanaan">Pelaksanaan</option>
                <option value="Pelaporan">Pelaporan</option>
            </select>
        </div>

        <div class="col-md-1 col-12 d-flex align-items-end">
            <button type="button" class="btn btn-danger remove-aktivitas">Delete</button>
        </div>
    `;

        aktivitasWrapper.appendChild(newAktivitasGroup);
    });

    document.getElementById('aktivitas-wrapper').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-aktivitas')) {
            event.target.closest('.row').remove();
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Select all update buttons
        const updateButtons = document.querySelectorAll(".updateReturBtn");

        updateButtons.forEach(button => {
            button.addEventListener("click", function() {
                // Get data attributes from clicked button
                const id = button.getAttribute("data-id");
                const nominal = button.getAttribute("data-nominal");
                const buktiLink = button.getAttribute("data-bukti");

                // Set form action to include the specific retur ID
                const updateForm = document.getElementById("updateReturForm");
                updateForm.action = `/retur/${id}`;

                // Populate modal fields with the selected retur data
                document.getElementById("nominal_retur").value = nominal;
                const currentBuktiLink = document.getElementById("current_bukti_retur");
                currentBuktiLink.href = buktiLink;
                currentBuktiLink.textContent = "View Current Bukti Retur";
            });
        });
    });
</script>

<script>
    function showModal(item) {
        // Set modal title and body dynamically
        document.getElementById('modalTitle').innerText = item.nama;
        document.getElementById('modalBody').innerText = item.deskripsi;

        // Show the modal
        var myModal = new bootstrap.Modal(document.getElementById('primary'));
        myModal.show();
    }
</script>