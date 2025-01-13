<?php require_once(__DIR__ . '/../../partials/headeruser.php'); ?>


<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
    <div class="container px-6 py-8 mx-auto">
        <div class="flex justify-between items-end mb-10">
            <h3 class="text-3xl font-medium text-gray-700">My Projects</h3>
            <form method="GET">
                <div class="relative mx-4 lg:mx-0">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none">
                            <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                    <input type="text" name="projectToSearch" onchange="this.form.submit()" class="w-32 pl-10 py-1 pr-4 rounded-md form-input sm:w-64 focus:border-indigo-600 focus:outline-none" placeholder="Search" value="<?= isset($_GET['projectToSearch']) ? htmlspecialchars($_GET['projectToSearch']) : '' ?>">
                </div>
            </form>
            <!-- filter by status -->
            <form method="GET">
                <select name="filter_by_status" class="rounded-lg px-2 py-1 focus:outline-none" onchange="this.form.submit()">
                    <option value="all" <?= isset($_GET['filter_by_status']) && $_GET['filter_by_status'] == 'all' ? 'selected' : '' ?>>All Status</option>
                    <option value="1" <?= isset($_GET['filter_by_status']) && $_GET['filter_by_status'] == '1' ? 'selected' : '' ?>>Pending</option>
                    <option value="2" <?= isset($_GET['filter_by_status']) && $_GET['filter_by_status'] == '2' ? 'selected' : '' ?>>In Progress</option>
                    <option value="3" <?= isset($_GET['filter_by_status']) && $_GET['filter_by_status'] == '3' ? 'selected' : '' ?>>Completed</option>
                </select>
            </form>
            <!-- filter by category -->
            <form method="GET">
                <select name="filter_by_cat" class="rounded-lg px-2 py-1 focus:outline-none" onchange="this.form.submit()">
                    <option value="all" <?= isset($_GET['filter_by_cat']) && $_GET['filter_by_cat'] == 'all' ? 'selected' : '' ?>>All Categories</option>
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?= htmlspecialchars($categorie['nom_categorie']); ?>"
                            <?= isset($_GET['filter_by_cat']) && $_GET['filter_by_cat'] == $categorie['nom_categorie'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categorie['nom_categorie']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
            <!-- filter by subcategory -->
            <form method="GET">
                <select name="filter_by_sub_cat" class="rounded-lg px-2 py-1 focus:outline-none" onchange="this.form.submit()">
                    <option value="all">All Subcategories</option>
                    <?php foreach ($subcategories as $subcategory): ?>
                        <option value="<?= htmlspecialchars($subcategory['nom_sous_categorie']) ?>" 
                            <?= isset($_GET['filter_by_sub_cat']) && $_GET['filter_by_sub_cat'] === $subcategory['nom_sous_categorie'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($subcategory['nom_sous_categorie']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <table class="min-w-full text-left">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Title</th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Description</th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Category</th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase border-b border-gray-200 bg-gray-50">SubCategory</th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Status</th>
                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <!-- projects -->
                <?php foreach ($projects as $project): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="project_title text-sm font-medium leading-5 text-gray-900"><?= htmlspecialchars($project['titre_projet']); ?></div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="project_description text-sm leading-5 text-gray-900 w-full"><?= $project['description'] !== null ? htmlspecialchars($project['description']) : ''; ?></div>
                        </td>

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="project_category text-sm leading-5 text-gray-900 w-full" data-category-id="<?= $project['id_categorie'] ?>"><?= $project['nom_categorie'] !== null ? htmlspecialchars($project['nom_categorie']) : ''; ?></div>
                        </td>

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="project_sub_category text-sm leading-5 text-gray-900 w-full" data-sous-category-id="<?= $project['id_sous_categorie'] ?>">
                                <?= $project['nom_sous_categorie'] !== null ? htmlspecialchars($project['nom_sous_categorie']) : ''; ?></div>
                        </td>

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="project_status text-sm leading-5 text-gray-900 w-full"><?= $project['project_status'] == 1 ? "Pending" : ($project['project_status'] == 2 ? "In Progress" : "Completed ") ?></div>
                        </td>

                        <td class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-b border-gray-200 flex justify-evenly">
                            <!-- modify button -->
                            <button data-project-id="<?= htmlspecialchars($project['id_projet']); ?>" class="modify_project_button text-indigo-600 hover:text-indigo-900">Modify</button>
                            <!-- Remove User Form with Confirmation -->
                            <form method="POST" action="/drop_project" class="mb-0" onsubmit="return confirm('Are you sure you want to remove this project?');">
                                <input type="hidden" name="id_projet" value="<?= $project['id_projet']; ?>">
                                <button type="submit" name="remove_project" class="text-indigo-600 hover:text-indigo-900">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <button id="add_project_button" class="text-gray-100 bg-gray-900 hover:bg-gray-700 p-3 mb-5 mr-5 rounded-sm float-right">Add Project</button>
</main>

<!-- Add Project Popup -->
<div id="project_modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center">
    <div id="modal_content" class="flex flex-col w-11/12 md:w-5/12 overflow-y-auto scrollbar-hidden mx-auto mt-10 p-4 bg-gray-200 rounded-sm shadow-lg">
        <div class="flex justify-between">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl">Add Project</h1>
            <!-- Close Icon -->
            <button id="close_project_modal" class="flex justify-end items-center mb-4 float-right text-xl">&times;</button>
        </div>
        <!-- Add Project Form -->
        <form method="POST" action="/add_updat_user_projet" id="project_form" class="mt-[25%] md:px-10">
            <!-- Project Title -->
            <div class="flex w-full mb-4">
                <label for="project_title_input" class="text-gray-900 font-semibold w-1/3">Project Title:</label>
                <input type="text" name="project_title_input" id="project_title_input" value="" class="w-2/3 border-gray-300 rounded-md" required>
            </div>

            <!-- Description -->
            <div class="flex w-full mb-4">
                <label for="project_description_input" class="text-gray-900 font-semibold w-1/3">Description:</label>
                <textarea name="project_description_input" id="project_description_input" rows="4" class="w-2/3 border-gray-300 rounded-md" required></textarea>
            </div>

            <!-- Category -->
            <div class="flex w-full mb-4">
                <label for="project_category_input" class="text-gray-900 font-semibold w-1/3">Category:</label>
                <select name="project_category_input" id="project_category_input" class="w-2/3 border-gray-300 rounded-md" required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?= htmlspecialchars($categorie['id_categorie']); ?>">
                            <?= htmlspecialchars($categorie['nom_categorie']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Subcategory -->
            <div class="flex w-full mb-4">
                <label for="project_subcategory_input" class="text-gray-900 font-semibold w-1/3">Subcategory:</label>
                <select name="project_subcategory_input" id="project_subcategory_input" class="w-2/3 border-gray-300 rounded-md" required>
                    <option value="">Select a subcategory</option>
                    <?php foreach ($subcategories as $subcategorie): ?>
                        <option value="<?= htmlspecialchars($subcategorie['id_sous_categorie']); ?>">
                            <?= htmlspecialchars($subcategorie['nom_sous_categorie']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Status select -->
            <div id="status_select" class="flex w-full mb-4">
                <label for="project_status" class="text-gray-900 font-semibold w-1/3">Status:</label>
                <select name="project_status" id="project_status" class="w-2/3 border-gray-300 rounded-md">
                    <option value="1">Pending</option>
                    <option value="2">In Progress</option>
                    <option value="3">Completed</option>
                </select>
            </div>

            <!-- Project ID hidden input -->
            <input type="hidden" name="project_id_input" id="project_id_input" value="0">

            <div class="flex justify-end">
                <button type="submit" name="save_project" class="text-gray-100 bg-gray-700 border-2 border-gray-700 hover:bg-gray-900 px-8 py-1 mt-6 rounded-sm">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<script data-cfasync="false" src="https://www.creative-tim.com/twcomponents/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"8e2ed63ffe793144","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"version":"2024.10.5","token":"1b7cbb72744b40c580f8633c6b62637e"}' crossorigin="anonymous"></script>

<script>
    const modal = document.getElementById('project_modal');
    document.getElementById('close_project_modal').onclick = () => closeModal();

    // Show modal as add project
    document.getElementById('add_project_button').onclick = () => {
        showModal();
        document.getElementById('project_form').classList.remove("hidden");
    }

    // Show modal as modify project
    const modifyProjectButtons = document.querySelectorAll(".modify_project_button");
    modifyProjectButtons.forEach(modifyProjectButton => {
        modifyProjectButton.onclick = () => {
            showModal();
            document.getElementById("project_title_input").value = modifyProjectButton.closest("tr").querySelector(".project_title").textContent;
            document.getElementById("project_description_input").value = modifyProjectButton.closest("tr").querySelector(".project_description").textContent;
            document.getElementById("project_category_input").value = modifyProjectButton.closest("tr").querySelector(".project_category").getAttribute("data-category-id");
            document.getElementById("project_subcategory_input").value = modifyProjectButton.closest("tr").querySelector(".project_sub_category").getAttribute("data-sous-category-id");
            document.getElementById("project_id_input").value = modifyProjectButton.getAttribute("data-project-id");
            document.getElementById("status_select").classList.remove("hidden");
        }
    });

    function showModal() {
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.getElementById("status_select").classList.add("hidden");
        document.getElementById('project_form').reset();
    }
    window.onclick = (event) => {
        if (event.target === modal) {
            closeModal();
        }
    };
</script>

<?php require_once(__DIR__ . '/../../partials/footer.php'); ?>