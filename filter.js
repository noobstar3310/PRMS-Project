document.addEventListener('DOMContentLoaded', function () {
    const recordsTable = document.getElementById('recordsTable');
    const searchPrInput = document.getElementById('searchPrInput');

    const filterEmptySOW = document.getElementById('filterEmptySOW');
    const filterEmptyCapexOpex = document.getElementById('filterEmptyCapexOpex');
    const filterEmptyAssignedStaff = document.getElementById('filterEmptyAssignedStaff');
    const filterEmptyLink = document.getElementById('filterEmptyLink');
    const clearFilters = document.getElementById('clearFilters');

    const applyFilters = document.getElementById('applyFilters');

    const bgDropdownMenu = document.getElementById('bgDropdownMenu');
    const sowDropdownMenu = document.getElementById('sowDropdownMenu');
    const workingGroupDropdownMenu = document.getElementById('workingGroupDropdownMenu');

    // Store initial table rows
    const allRows = Array.from(recordsTable.querySelectorAll('tbody tr'));

    // Initialize dropdowns based on available data in the table
    initializeDropdowns(allRows);

    // Search PR Number
    searchPrInput.addEventListener('input', function () {
        const searchValue = searchPrInput.value.toLowerCase();
        filterRows(searchValue, '', '', '');
    });

    // Apply Filter by multiple fields
    applyFilters.addEventListener('click', function () {
        const selectedBGs = getSelectedCheckboxValues(bgDropdownMenu);
        const selectedSowNos = getSelectedCheckboxValues(sowDropdownMenu);
        const selectedWorkingGroups = getSelectedCheckboxValues(workingGroupDropdownMenu);

        filterRows(searchPrInput.value.toLowerCase(), selectedBGs, selectedSowNos, selectedWorkingGroups);
    });

    // Filter Empty Fields Logic
    filterEmptySOW.addEventListener('click', function () {
        filterRowsByEmptyField('SOW No');
    });

    filterEmptyCapexOpex.addEventListener('click', function () {
        filterRowsByEmptyField('Total CAPEX (USD)', 'Estimated OPEX (USD)');
    });

    filterEmptyAssignedStaff.addEventListener('click', function () {
        filterRowsByEmptyField('Assigned Staff');
    });

    filterEmptyLink.addEventListener('click', function () {
        filterRowsByEmptyField('Link');
    });

    // Clear All Filters
    clearFilters.addEventListener('click', function () {
        allRows.forEach(row => row.style.display = '');
        searchPrInput.value = '';
    });

    function getSelectedCheckboxValues(menu) {
        const checkboxes = menu.querySelectorAll('input[type="checkbox"]');
        return Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);
    }

    function filterRows(searchValue, selectedBGs, selectedSowNos, selectedWorkingGroups) {
        allRows.forEach(row => {
            const prNo = row.cells[3].innerText.toLowerCase();
            const bg = row.cells[0].innerText;
            const sowNo = row.cells[4].innerText;
            const workingGroup = row.cells[7].innerText;

            const show = (!searchValue || prNo.includes(searchValue)) &&
                (!selectedBGs.length || selectedBGs.includes(bg)) &&
                (!selectedSowNos.length || selectedSowNos.includes(sowNo)) &&
                (!selectedWorkingGroups.length || selectedWorkingGroups.includes(workingGroup));

            row.style.display = show ? '' : 'none';
        });
    }

    function filterRowsByEmptyField(...fieldNames) {
        allRows.forEach(row => {
            const fields = fieldNames.map(name => row.querySelector(`td:contains(${name})`).innerText.trim());
            const show = fields.some(field => !field || field === '0' || field === 'NULL');

            row.style.display = show ? '' : 'none';
        });
    }

    // Initialize dropdowns for BG, SOW No, and Working Group
    function initializeDropdowns(rows) {
        const bgSet = new Set();
        const sowSet = new Set();
        const wgSet = new Set();

        rows.forEach(row => {
            const bg = row.cells[0].innerText.trim() || '*blank*';
            const sowNo = row.cells[4].innerText.trim() || '*blank*';
            const workingGroup = row.cells[7].innerText.trim() || '*blank*';

            bgSet.add(bg);
            sowSet.add(sowNo);
            wgSet.add(workingGroup);
        });

        populateDropdown(bgDropdownMenu, Array.from(bgSet));
        populateDropdown(sowDropdownMenu, Array.from(sowSet));
        populateDropdown(workingGroupDropdownMenu, Array.from(wgSet));
    }

    // Populate dropdown with options
    function populateDropdown(menu, options) {
        menu.innerHTML = '';
        options.forEach(option => {
            const li = document.createElement('li');
            li.innerHTML = `<label><input type="checkbox" value="${option}"> ${option}</label>`;
            menu.appendChild(li);
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const recordsTable = document.getElementById('recordsTable');
    const allRows = Array.from(recordsTable.querySelectorAll('tbody tr'));

    const searchPrInput = document.getElementById('searchPrInput');
    const filterEmptySOW = document.getElementById('filterEmptySOW');
    const filterEmptyCapexOpex = document.getElementById('filterEmptyCapexOpex');
    const filterEmptyAssignedStaff = document.getElementById('filterEmptyAssignedStaff');
    const filterEmptyLink = document.getElementById('filterEmptyLink');
    const clearFilters = document.getElementById('clearFilters');
    const applyFilters = document.getElementById('applyFilters');

    const bgDropdownMenu = document.getElementById('bgDropdownMenu');
    const sowDropdownMenu = document.getElementById('sowDropdownMenu');
    const workingGroupDropdownMenu = document.getElementById('workingGroupDropdownMenu');

    // Event: Search by PR Number
    searchPrInput.addEventListener('input', function () {
        const searchValue = searchPrInput.value.toLowerCase();
        filterRows(searchValue, '', '', '');
    });

    // Event: Apply Filters
    applyFilters.addEventListener('click', function () {
        const selectedBGs = getSelectedCheckboxValues(bgDropdownMenu);
        const selectedSowNos = getSelectedCheckboxValues(sowDropdownMenu);
        const selectedWorkingGroups = getSelectedCheckboxValues(workingGroupDropdownMenu);
        filterRows(searchPrInput.value.toLowerCase(), selectedBGs, selectedSowNos, selectedWorkingGroups);
    });

    // Event: Filter by Empty SOW No
    filterEmptySOW.addEventListener('click', function () {
        filterRowsByEmptyField('SOW NO');
    });

    // Event: Filter by Empty CAPEX/OPEX
    filterEmptyCapexOpex.addEventListener('click', function () {
        filterRowsByEmptyField('Total CAPEX (USD)', 'Estimated OPEX (USD)');
    });

    // Event: Filter by Empty Assigned Staff
    filterEmptyAssignedStaff.addEventListener('click', function () {
        filterRowsByEmptyField('Assigned Staff');
    });

    // Event: Filter by Empty Link
    filterEmptyLink.addEventListener('click', function () {
        filterRowsByEmptyField('Link');
    });

    // Event: Clear Filters
    clearFilters.addEventListener('click', function () {
        allRows.forEach(row => row.style.display = '');
        searchPrInput.value = '';
    });

    // Function: Get selected checkboxes from dropdown menu
    function getSelectedCheckboxValues(menu) {
        const checkboxes = menu.querySelectorAll('input[type="checkbox"]');
        return Array.from(checkboxes).filter(checkbox => checkbox.checked).map(checkbox => checkbox.value);
    }

    // Function: Filter rows based on search and dropdown filters
    function filterRows(searchValue, selectedBGs, selectedSowNos, selectedWorkingGroups) {
        allRows.forEach(row => {
            const prNo = row.cells[3].innerText.toLowerCase();
            const bg = row.cells[0].innerText;
            const sowNo = row.cells[4].innerText;
            const workingGroup = row.cells[7].innerText;

            const show = (!searchValue || prNo.includes(searchValue)) &&
                (!selectedBGs.length || selectedBGs.includes(bg)) &&
                (!selectedSowNos.length || selectedSowNos.includes(sowNo)) &&
                (!selectedWorkingGroups.length || selectedWorkingGroups.includes(workingGroup));

            row.style.display = show ? '' : 'none';
        });
    }

    // Function: Filter rows with empty fields
    function filterRowsByEmptyField(...fieldNames) {
        allRows.forEach(row => {
            let show = false;
            fieldNames.forEach(fieldName => {
                const cellText = row.querySelector(`td:nth-child(${getFieldIndex(fieldName)})`).innerText.trim();
                if (!cellText || cellText === '0' || cellText === 'NULL') {
                    show = true;
                }
            });
            row.style.display = show ? '' : 'none';
        });
    }

    // Utility: Get column index based on field name
    function getFieldIndex(fieldName) {
        switch (fieldName) {
            case 'SOW NO': return 5;
            case 'Total CAPEX (USD)': return 18;
            case 'Estimated OPEX (USD)': return 19;
            case 'Assigned Staff': return 10;
            case 'Link': return 17;
            default: return -1;
        }
    }
});
