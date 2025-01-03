<?php require_once(__DIR__.'/../../partials/header.php');?>





<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
    <div class="container px-6 py-8 mx-auto">
        <h3 class="text-3xl font-medium text-gray-700 mb-6">Statistics</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Users -->
            <div class="bg-white p-6 rounded-lg shadow-md ">
                <h4 class="text-lg font-semibold text-gray-600">Total Users</h4>
                <p class="mt-4 text-3xl font-bold text-indigo-600"><?= htmlspecialchars($statistics['total_users']); ?></p>
            </div>
            <!-- Total Published Projects -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h4 class="text-lg font-semibold text-gray-600">Total Published Projects</h4>
                <p class="mt-4 text-3xl font-bold text-indigo-600"><?= htmlspecialchars($statistics['total_projects']); ?></p>
            </div>
            <!-- Total Freelancers -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h4 class="text-lg font-semibold text-gray-600">Total Freelancers</h4>
                <p class="mt-4 text-3xl font-bold text-indigo-600"><?= htmlspecialchars($statistics['total_freelancers']); ?></p>
            </div>
            <!-- Ongoing Offers -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h4 class="text-lg font-semibold text-gray-600">Ongoing Offers</h4>
                <p class="mt-4 text-3xl font-bold text-indigo-600"><?= htmlspecialchars($statistics['ongoing_offers']); ?></p>
            </div>
        </div>
    </div>
</main>




<?php require_once(__DIR__.'/../../partials/footer.php');?>