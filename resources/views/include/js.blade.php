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
    // Adding dynamic Outcome input fields
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

    // Adding dynamic Indikator input fields
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

    let aktivitasCount = 1;

// Function to add event listeners for budget modals
function addBudgetModalListener(modalId, aktivitasId) {
    document.getElementById(`add-budget-need-${aktivitasId}`).addEventListener('click', function() {
        const budgetNeedsWrapper = document.getElementById(`budget-needs-wrapper-${aktivitasId}`);
        const newBudgetNeedRow = document.createElement('div');
        newBudgetNeedRow.classList.add('form-group');
        newBudgetNeedRow.innerHTML = `
            <label for="uraian_aktivitas">Uraian Aktivitas</label>
            <input type="text" name="uraian_aktivitas[]" class="form-control mb-2">
            <label for="frekwensi">Frekwensi</label>
            <input type="number" name="frekwensi[]" class="form-control mb-2">
            <label for="nominal_volume">Nominal Volume</label>
            <input type="number" name="nominal_volume[]" class="form-control mb-2">
            <label for="satuan_volume">Satuan Volume</label>
            <input type="text" name="satuan_volume[]" class="form-control mb-2">
            <label for="jumlah">Jumlah</label>
            <input type="number" name="jumlah[]" class="form-control mb-2">
            <button type="button" class="btn btn-danger btn-sm remove-budget-need">Delete</button>
        `;

        // Append new budget need row
        budgetNeedsWrapper.appendChild(newBudgetNeedRow);

        // Add remove functionality for new budget need row
        newBudgetNeedRow.querySelector('.remove-budget-need').addEventListener('click', function() {
            newBudgetNeedRow.remove();
        });
    });
}

// Initial budget modal listener for the first modal
addBudgetModalListener('budgetModal1', 1);

document.getElementById('add-aktivitas').addEventListener('click', function() {
    aktivitasCount++;
    const aktivitasWrapper = document.getElementById('aktivitas-wrapper');
    const modalPlaceholder = document.getElementById('modal-placeholder');

    const newAktivitasGroup = document.createElement('div');
    newAktivitasGroup.classList.add('form-group', 'd-flex');
    newAktivitasGroup.id = 'aktivitas-group-' + aktivitasCount;

    // Generate unique modal ID
    const modalId = 'budgetModal' + aktivitasCount;

    // Constructing the new Aktivitas form group dynamically
    newAktivitasGroup.innerHTML = `
        <div class="col-md-3 col-12">
            <label for="waktu_aktivitas">Waktu Aktivitas</label>
            <input type="date" name="waktu_aktivitas[]" class="form-control" placeholder="mm/dd/yyyy">
        </div>

        <div class="col-md-5 col-12">
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
            <!-- Modal Trigger for Budget Needs -->
            <button type="button" class="btn btn-primary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#${modalId}">Add Budget Needs</button>
        </div>
    `;

    // Append the new Aktivitas group to the wrapper
    aktivitasWrapper.appendChild(newAktivitasGroup);

    // Add event listener to the new delete button to remove the aktivitas group
    newAktivitasGroup.querySelector('.remove-aktivitas').addEventListener('click', function() {
        newAktivitasGroup.remove();
        // Optionally, you can also remove the associated modal
        document.getElementById(modalId).remove();
    });

    // Create a new modal for this aktivitas
    const newModal = document.createElement('div');
    newModal.classList.add('modal', 'fade');
    newModal.id = modalId;
    newModal.tabIndex = -1;
    newModal.ariaLabelledBy = 'budgetModalLabel';
    newModal.ariaHidden = 'true';
    newModal.innerHTML = `
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="budgetModalLabel">Input Budget Needs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="budget-needs-wrapper-${aktivitasCount}">
                        <div class="form-group">
                            <label for="uraian_aktivitas">Uraian Aktivitas</label>
                            <input type="text" name="uraian_aktivitas[]" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="frekwensi">Frekwensi</label>
                            <input type="number" name="frekwensi[]" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nominal_volume">Nominal Volume</label>
                            <input type="number" name="nominal_volume[]" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="satuan_volume">Satuan Volume</label>
                            <input type="text" name="satuan_volume[]" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah[]" class="form-control">
                        </div>
                    </div>
                    <button type="button" class="btn btn-success" id="add-budget-need-${aktivitasCount}">Add More Budget Need</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save Budget Needs</button>
                </div>
            </div>
        </div>
    `;

    // Append the new modal to the placeholder
    modalPlaceholder.appendChild(newModal);

    // Add event listener to the newly created budget modal
    addBudgetModalListener(modalId, aktivitasCount);
});





    // Event delegation to remove outcome/indikator/aktivitas
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-outcome')) {
            event.target.parentElement.remove();
        }
        if (event.target.classList.contains('remove-indikator')) {
            event.target.parentElement.remove();
        }
    });
</script>