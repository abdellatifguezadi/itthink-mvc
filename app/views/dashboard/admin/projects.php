<?php require_once(__DIR__ . '/../../partials/header.php'); ?>





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
                <select name="filter_by_sub_cat" class="rounded-lg px-2 py-1 focus:outline-none" onchange="this.form.submit()">
                    <option value="all" <?= isset($_GET['filter_by_sub_cat']) && $_GET['filter_by_sub_cat'] == 'all' ? 'selected' : '' ?>>All Subcategories</option>
                    <?php foreach ($categories as $categorie): ?>
                        <?php if (isset($categorie['sous_categories']) && is_array($categorie['sous_categories'])): ?>
                            <?php foreach ($categorie['sous_categories'] as $sousCategorie): ?>
                                <option value="<?= htmlspecialchars($sousCategorie['nom_sous_categorie']); ?>"
                                    <?= isset($_GET['filter_by_sub_cat']) && $_GET['filter_by_sub_cat'] == $sousCategorie['nom_sous_categorie'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($sousCategorie['nom_sous_categorie']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </select>
            </form>
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
                            <!-- Remove Project Form with Confirmation -->
                            <form method="POST" action="/delete_projet" class="mb-0" onsubmit="return confirm('Are you sure you want to remove this project?');">
                                <input type="hidden" name="id_projet" value="<?= $project['id_projet']; ?>">
                                <button type="submit" action="/delete_projet" name="remove_project" class="text-indigo-600 hover:text-indigo-900">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>




<?php require_once(__DIR__ . '/../../partials/footer.php'); ?>