fetch('./topbar.html')
    .then(response => response.text())
    .then(data => {
        document.getElementById('topbarContainer').innerHTML = data;
        function toggleDropdown(btnId, dropdownId) {
            const button = document.getElementById(btnId);
            const dropdown = document.getElementById(dropdownId);

            button.addEventListener('click', function () {
                dropdown.classList.toggle('hidden');
            })
            window.addEventListener('click', function (event) {
                if (!event.target.closest('#' + btnId) && !event.target.closest('#' + dropdownId)) {
                    dropdown.classList.add('hidden');
                }
            });
        }

    toggleDropdown('admissionBtn', 'admissionDropdown');
    toggleDropdown('aboutBtn', 'aboutDropdown');
});