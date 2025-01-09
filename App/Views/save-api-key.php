<?php
$update = get_option('gpr_update_api_key');
?>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="wrap p-3">
    <h1 class="gpr-heading text-black text-4xl font-bold mb-4">Google Place Reviews</h1>
    <p class="gpr-subheading text-black text-sm mb-6">Please follow these steps to set up your Google Places API key:</p>

    <form id="gpr-api-key-form" method="POST" class="gpr-form flex items-center space-x-4 mb-8">
        <input
            type="text"
            id="gpr-api-key"
            class="gpr-input-field flex-grow h-9 px-4 border border-black rounded-md text-black focus:outline-none focus:ring-2 focus:ring-gray-400"
            placeholder="Enter your API key..."
        />
        <?php if ($update === 'update') { ?>
            <button
                id="gpr-api-key-submit"
                class="h-9 px-6 border-2 border-black text-black bg-white rounded-md hover:bg-black hover:text-white transition-all duration-300"
            >
                Update API Key
            </button>
        <?php } else { ?>
            <button
                id="gpr-api-key-submit"
                class="h-9 px-6 border-2 border-black text-black bg-white rounded-md hover:bg-black hover:text-white transition-all duration-300"
            >
                Save API Key
            </button>
        <?php } ?>
    </form>

    <ol class="gpr-steps list-decimal pl-5 text-gray-800 text-base leading-relaxed space-y-4">
        <li>Visit <a href="https://console.cloud.google.com/" target="_blank" class="text-blue-500 underline">Google Cloud Console</a> and sign in.</li>
        <li>Click the <b>Project dropdown</b> in the top-left corner and select <b>New Project</b>. Enter a name for your project and click <b>Create</b>.</li>
        <li>Search for <b>Places API</b> in the search bar, click on it, and then click <b>Enable</b> to activate the API for your project.</li>
        <li>Go to <b>APIs & Services > Credentials</b>, click <b>Create Credentials</b>, and select <b>API Key</b>. Your API Key will be generated.</li>
        <li>Click <b>Restrict Key</b>, set <b>HTTP Referrers</b> for your domain, select <b>Places API</b> under <b>API Restrictions</b>, and click <b>Save</b>.</li>
    </ol>

    <p class="gpr-subheading text-black text-sm mt-8">After completing the steps, enter your API key above:</p>

    <div id="gpr-api-status" class="gpr-status mt-4 text-gray-700 text-center"></div>
</div>
