jQuery(document).ready(function ($) {
    function toastMessage(type, text) {
        let newToast = document.createElement('div');
        let icon = '';
        if (type === 'success') {
            icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"\n' +
                '         stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check">\n' +
                '        <path d="M20 6 9 17l-5-5"/>\n' +
                '    </svg>'
        } else if (type === 'error') {
            icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-octagon-alert"><path d="M12 16h.01"/><path d="M12 8v4"/><path d="M15.312 2a2 2 0 0 1 1.414.586l4.688 4.688A2 2 0 0 1 22 8.688v6.624a2 2 0 0 1-.586 1.414l-4.688 4.688a2 2 0 0 1-1.414.586H8.688a2 2 0 0 1-1.414-.586l-4.688-4.688A2 2 0 0 1 2 15.312V8.688a2 2 0 0 1 .586-1.414l4.688-4.688A2 2 0 0 1 8.688 2z"/></svg>';
        }
        newToast.classList.add('edwm-toast', type);
        newToast.innerHTML = `
        <div class='edwm-toast-icon edwm-toast-icon-${type}'>${icon}</div>
        <div class="edwm-toast-content">
            <span class="edwm-toast-msg">${text}</span>
        </div>
        <i class="edpw edpw-close"  style="font-size:17px;color:#666;cursor: pointer" onclick="(this.parentElement).remove()"></i>`;
        document.querySelector('.yuko-notification').appendChild(newToast);
        newToast.timeOut = setTimeout(function () {
            newToast.remove();
        }, 100000);
    }
    $('#gpr-search-btn').on('click', function () {
        const query = $('#gpr-place-search').val();
        if (!query) {
            toastr.error('Please enter a place name.');
            return;
        }

        $.ajax({
            url: gprData.ajax_url,
            method: 'POST',
            data: {
                action: 'gpr_fetch_place_id',
                security: gprData.nonce,
                query: query,
            },
            beforeSend: function () {
                $('#gpr-result').html('Searching...');
            },
            success: function (response) {
                if (response.success) {
                    toastMessage('success','Place reviews fetched successfully!')
                    $('#gpr-result').html(response.data.content);
                } else {
                    toastMessage('error',response.data.message)
                    $('#gpr-result').html(`<span style="color: red;">${response.data.message}</span>`);
                }
            },
            error: function () {
                toastMessage('error','Failed to fetch Place ID and reviews.')
                $('#gpr-result').html('<span style="color: red;">Failed to fetch Place ID and reviews.</span>');
            },
        });
    });

    // Handle the API key submission
    $('#gpr-api-key-submit').on('click', function (e) {
        e.preventDefault(); // Prevent form submission
        const apiKey = $('#gpr-api-key').val();
        if (!apiKey) {
            toastMessage('error','Please enter an API key.')
            return;
        }

        $.ajax({
            url: gprData.ajax_url,
            method: 'POST',
            data: {
                action: 'gpr_save_api_key',
                nonce: gprData.nonce,
                api_key: apiKey,
            },
            beforeSend: function () {
                $('#gpr-api-status').html('Saving API key...');
            },
            success: function (response) {
                if (response.success) {
                    toastMessage('success',response.data.message)
                    setTimeout(() => location.reload(), 1000);
                } else {
                    toastMessage('error',response.data.message)
                }
            },
            error: function () {
                toastMessage('error','Failed to save API key. Please try again.')
            },
        });
    });

    $('#gpr-update-api-btn').on('click', function () {
        $.ajax({
            url: gprData.ajax_url,
            method: 'POST',
            data: {
                action: 'gpr_update_api_key',
                nonce: gprData.nonce,
                update: 'update'
            },
            beforeSend: function () {
                $('#gpr-api-status').html('Saving API key...');
            },
            success: function (response) {
                if (response.success) {
                    $('#gpr-api-status').html(
                        `<span style="color: green;">${response.data.html}</span>`
                    );
                    setTimeout(() => location.reload(), 1000);
                } else {
                    toastMessage('error',response.data.message)
                }
            },
            error: function () {
                toastMessage('error','Failed to save API key. Please try again.')
            },
        });
    });
});
// Get references to the input field, search button, and result container
const searchInput = document.getElementById('gpr-place-search');
const searchButton = document.getElementById('gpr-search-btn');
const resultContainer = document.getElementById('gpr-result');

// Function to check the input field and enable/disable the search button
function toggleSearchButton() {
    if (searchInput.value.trim() === "") {
        // Disable the search button if the input field is empty
        searchButton.disabled = true;
        searchButton.classList.add('opacity-50'); // Optional: visually show the button is disabled
    } else {
        // Enable the search button if there is text in the input field
        searchButton.disabled = false;
        searchButton.classList.remove('opacity-50');
    }
}

// Listen for changes in the input field to toggle the search button state
searchInput.addEventListener('input', toggleSearchButton);

// Initially disable the search button if the input is empty
toggleSearchButton();

// Function to simulate search action (you can replace this with your actual search logic)
function performSearch() {
    const searchQuery = searchInput.value.trim();

    if (searchQuery) {
        // Disable the search button after search is triggered
        searchButton.disabled = true;
        searchButton.classList.add('opacity-50'); // Optional: visually show the button is disabled

        // Simulate an API call or search process
        setTimeout(function () {
            // Example of result data (you can replace with actual API response)
            const searchResult = `<p>Showing results for: ${searchQuery}</p>`;

            // Display the results in the result container
            resultContainer.innerHTML = searchResult;
        }, 1000); // Simulated delay (1 second for example)
    }
}

// Event listener for the search button click to trigger the search
searchButton.addEventListener('click', function (e) {
    e.preventDefault(); // Prevent default button behavior
    performSearch(); // Call the performSearch function when button is clicked
});

// Function to re-enable the search button when the input is edited after search
searchInput.addEventListener('input', function() {
    // Re-enable the search button only if input is changed after search
    if (!searchButton.disabled) return; // If already enabled, do nothing
    searchButton.disabled = false;
    searchButton.classList.remove('opacity-50');
});



