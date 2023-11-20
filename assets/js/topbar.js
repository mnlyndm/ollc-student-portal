function toggleDropdown(btnId, dropdownId) {
    const button = document.getElementById(btnId);
    const dropdown = document.getElementById(dropdownId);

    button.addEventListener('click', function () {
        dropdown.classList.toggle('hidden');
    });

    window.addEventListener('click', function (event) {
        if (!event.target.closest('#' + btnId) && !event.target.closest('#' + dropdownId)) {
            dropdown.classList.add('hidden');
        }
    });
}

toggleDropdown('admissionBtn', 'admissionDropdown');
toggleDropdown('aboutBtn', 'aboutDropdown');