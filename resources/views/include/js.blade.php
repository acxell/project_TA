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

    // Adding dynamic Aktivitas input fields for each category with cleaner form structure
    const categories = ['persiapan', 'pelaksanaan', 'pelaporan'];

    categories.forEach(function(category) {
        let count = 1;
        document.getElementById('add-' + category).addEventListener('click', function() {
            count++;
            const wrapper = document.getElementById(category + '-wrapper');
            const newGroup = document.createElement('div');
            newGroup.classList.add('form-group', 'd-flex', 'align-items-center', 'mb-2');
            newGroup.id = category + '-group-' + count;
            newGroup.innerHTML = `
            <input type="date" name="waktu_${category}[]" class="form-control me-2" placeholder="Waktu ${category}">
            <textarea name="penjelasan_${category}[]" class="form-control me-2" placeholder="Penjelasan ${category}" rows="1"></textarea>
            <button type="button" class="btn btn-danger remove-${category}">Delete</button>`;
            wrapper.appendChild(newGroup);
        });
    });

    // Event delegation to remove dynamic aktivitas forms
    document.addEventListener('click', function(event) {
        categories.forEach(function(category) {
            if (event.target.classList.contains('remove-' + category)) {
                event.target.parentElement.remove();
            }
        });
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