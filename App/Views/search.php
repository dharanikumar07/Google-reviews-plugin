<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<div class="gpr-wrap relative p-3">
    <div class="flex justify-between items-center">
        <h1 class="gpr-heading text-black text-2xl font-semibold">Google Place Reviews</h1>
        <button id="gpr-update-api-btn" class="gpr-button gpr-button-secondary px-6 py-2 border-2 border-black text-black bg-transparent rounded-md hover:bg-gray-800 hover:text-white hover:border-white transition-all duration-300">
            Update API Key
        </button>
    </div>
    <p class="gpr-description text-black mt-2">Search a place to get its reviews</p>

    <div id="gpr-search-wrap" class="gpr-search-wrap mt-5 flex space-x-4">
        <input type="text" id="gpr-place-search" class="gpr-input-field w-full px-4 py-2 border-2 border-black rounded-md text-black focus:outline-none focus:ring-2 focus:ring-gray-400" placeholder="Enter a place name..." />
        <button id="gpr-search-btn" class="gpr-button gpr-button-primary px-6 py-2 border-2 border-black text-black bg-transparent rounded-md hover:bg-gray-800 hover:text-white hover:border-white transition-all duration-300" disabled>
            Search
        </button>
    </div>

    <div id="gpr-result" class="gpr-result mt-5">No reviews....</div>
</div>
