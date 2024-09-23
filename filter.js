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
        filterRowsByEmptyField(4); // Column index for SOW No
    });

    filterEmptyCapexOpex.addEventListener('click', function () {
        filterRowsByEmptyCapexOpex(18, 19); // Column index for CAPEX and OPEX
    });

    // Filter for Empty Assigned Staff
    filterEmptyAssignedStaff.addEventListener('click', function () {
        filterRowsByEmptyField(9); // Column index for Assigned Staff
    });

    filterEmptyLink.addEventListener('click', function () {
        filterRowsByEmptyField(17); // Column index for Link
    });

    // Clear All Filters (this refreshes the page to reset all filters)
    clearFilters.addEventListener('click', function () {
        window.location.reload(); // Refreshes the page to clear all filters
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
            const sowNo = row.cells[4].innerText.trim(); // SOW No column
            const workingGroup = row.cells[7].innerText;
    
            // Handle case for selecting "*blank*" for SOW No
            const sowMatch = (!selectedSowNos.length || 
                             (selectedSowNos.includes('*blank*') && (!sowNo || sowNo === '')) ||
                             selectedSowNos.includes(sowNo));
    
            const show = (!searchValue || prNo.includes(searchValue)) &&
                         (!selectedBGs.length || selectedBGs.includes(bg)) &&
                         sowMatch &&
                         (!selectedWorkingGroups.length || selectedWorkingGroups.includes(workingGroup));
    
            row.style.display = show ? '' : 'none';
        });
    }

    // Function: Filter rows by empty fields (for single columns like SOW No, Assigned Staff, Link)
    function filterRowsByEmptyField(columnIndex) {
        allRows.forEach(row => {
            const cellValue = row.cells[columnIndex].innerText.trim();
            const isEmpty = !cellValue || cellValue === '0' || cellValue === 'NULL' || cellValue === '' || cellValue === '-';
            row.style.display = isEmpty ? '' : 'none'; // Show rows where the field is empty
        });
    }

    // Function: Filter rows by empty CAPEX/OPEX (both must be empty or 0)
    function filterRowsByEmptyCapexOpex(capexIndex, opexIndex) {
        allRows.forEach(row => {
            const capex = row.cells[capexIndex].innerText.trim();
            const opex = row.cells[opexIndex].innerText.trim();

            // Check if CAPEX and OPEX are empty or zero
            const isCapexEmpty = !capex || capex === '0' || capex === 'NULL' || capex === '';
            const isOpexEmpty = !opex || opex === '0' || opex === 'NULL' || opex === '';

            // Both CAPEX and OPEX must be empty or zero for the row to be shown
            const isEmptyCapexOpex = isCapexEmpty && isOpexEmpty;

            row.style.display = isEmptyCapexOpex ? '' : 'none';
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
