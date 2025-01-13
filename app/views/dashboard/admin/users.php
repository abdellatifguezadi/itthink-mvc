<?php require_once(__DIR__.'/../../partials/header.php');?>




<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container px-6 py-8 mx-auto">
                    <div class="flex justify-between">
                    <h3 class="text-3xl font-medium text-gray-700">Users</h3>

                    <!-- Formulaire de recherche -->
                    <form method="GET" class="mb-4">
                        <div class="flex items-center space-x-4">
                            <!-- Filtre -->
                            <select name="filter" class="rounded-lg px-2 py-1 focus:outline-none" onchange="this.form.submit()">
                                <option value="all" <?= $currentFilter === 'all' ? 'selected' : '' ?>>Tous les utilisateurs</option>
                                <option value="clients" <?= $currentFilter === 'clients' ? 'selected' : '' ?>>Clients</option>
                                <option value="freelancers" <?= $currentFilter === 'freelancers' ? 'selected' : '' ?>>Freelancers</option>
                            </select>

                            <!-- Recherche -->
                            <div class="relative">
                                <input type="text" 
                                       name="userToSearch" 
                                       value="<?= htmlspecialchars($searchTerm) ?>" 
                                       placeholder="Rechercher un utilisateur..."
                                       class="pl-10 pr-4 py-2 rounded-md border focus:outline-none focus:border-indigo-500">
                                <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
    
                    <div class="flex flex-col mt-8">
                        <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                            <div
                                class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
                                <table class="min-w-full">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                                Name</th>
                                            <th
                                                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                                Title</th>
                                            <th
                                                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                                Status</th>
                                            <th
                                                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                                Role</th>
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                                        </tr>
                                    </thead>
    
                                    <tbody class="bg-white">
                                        <!-- users -->
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 w-10 h-10 bg-gray-500 text-gray-100 text-2xl rounded-full flex justify-center items-center uppercase">
                                                            <?= htmlspecialchars($user['nom_utilisateur'])[0] ?>
                                                        </div>
        
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium leading-5 text-gray-900"><?= htmlspecialchars($user['nom_utilisateur']); ?></div>
                                                            <div class="text-sm leading-5 text-gray-500"><?= htmlspecialchars($user['email']); ?>
                                                        </div>
                                                    </div>
                                                </td>
        
                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                    <div class="text-sm leading-5 text-gray-900 w-full"><?= $user['title'] !== null ? htmlspecialchars($user['title']) : ''; ?></div>
                                                </td>
        
                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                    <form method="POST" action="/status_user" style="display:inline;" onsubmit="return confirm('Are you sure you want to change the status of this user?');">
                                                        <input type="hidden" name="block_user_id" value="<?= $user['id_utilisateur']; ?>">
                                                            <button type="submit" class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                                                <?= $user['is_active']==1?"Active": "blocked"?>
                                                            </button>
                                                    </form>
                                                </td>
        
                                                <td class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                                    <?= $user['role']== 2 ? "Client":"Freelancer"; ?>
                                                </td>
        
                                                <td class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-b border-gray-200">
                                                    <!-- Remove User Form with Confirmation -->
                                                    <form method="POST" action="/remove_user" style="display:inline;" onsubmit="return confirm('Are you sure you want to remove this user?');">
                                                        <input type="hidden" name="remove_user" value="<?= $user['id_utilisateur']; ?>">
                                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900">Remove</button>
                                                    </form>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
  



<?php require_once(__DIR__.'/../../partials/footer.php');?>