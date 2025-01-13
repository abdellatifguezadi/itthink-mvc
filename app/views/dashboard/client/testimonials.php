<?php require_once(__DIR__ . '/../../partials/headeruser.php'); ?>






<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container px-6 py-8 mx-auto">
                    <h3 class="text-3xl font-medium text-gray-700 mb-10">My Testimonials</h3>
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Project Title</th>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Comment</th>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Amount</th>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Deadline</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <?php foreach ($clientTestimonials as $clientTestimonial): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="flex items-center">
                                            <div class="text-sm leading-5 text-gray-500"><?= htmlspecialchars($clientTestimonial['titre_projet']); ?>
                                        </div>
                                    </td>
        
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="testimonial_comment text-sm leading-5 text-gray-900 w-full"><?= htmlspecialchars($clientTestimonial['commentaire']); ?></div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-900 w-full"><?= htmlspecialchars($clientTestimonial['montant']); ?></div>
                                    </td>
        
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-900 w-full"><?= htmlspecialchars($clientTestimonial['delai']); ?></div>
                                    </td>
        
                                    <td class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-b border-gray-200 flex justify-evenly">
                                        <!-- modify button -->
                                        <button data-testimonial-id="<?= htmlspecialchars($clientTestimonial['id_temoignage']); ?>" data-offre-id="<?= htmlspecialchars($clientTestimonial['id_offre']); ?>" class="modify_testimonial_button text-indigo-600 hover:text-indigo-900">Modify</button>
                                        <!-- Remove User Form with Confirmation -->
                                        <form method="POST" action="/remove_testo_user" class="mb-0" onsubmit="return confirm('Are you sure you want to remove this Testimonial?');">
                                            <input type="hidden" name="id_temoignage" value="<?= $clientTestimonial['id_temoignage']; ?>">
                                            <button type="submit" name="remove_testimonial" class="text-indigo-600 hover:text-indigo-900">Remove</button>
                                        </form>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>

<!-- Modal pour modifier le témoignage -->
<div id="testimonial_modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center">
    <div id="modal_content" class="flex flex-col w-11/12 md:w-5/12 overflow-y-auto scrollbar-hidden mx-auto mt-10 p-4 bg-gray-200 rounded-sm shadow-lg">
        <div class="flex justify-between">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl">Modify Testimonial</h1>
            <button id="close_testimonial_modal" class="flex justify-end items-center mb-4 float-right text-xl">&times;</button>
        </div>
        
        <form method="POST" action="/addorupdatetesto" id="testimonial_form" class="mt-[25%] md:px-10">
            <div class="flex w-full mb-4">
                <label for="commentaire_input" class="text-gray-900 font-semibold w-1/3">Commentaire:</label>
                <textarea name="commentaire_input" id="commentaire_input" class="w-2/3 border-gray-300 rounded-md p-4" required></textarea>
            </div>

            <input type="hidden" name="offre_id_input" id="offre_id_input">
            <input type="hidden" name="testimonial_id_input" id="testimonial_id_input">

            <div class="flex justify-end">
                <input type="submit" name="save_testimonial" class="text-gray-100 bg-gray-700 border-2 border-gray-700 hover:bg-gray-900 px-8 py-1 mt-6 rounded-sm" value="Save">
            </div>
        </form>
    </div>
</div>

<script>
    const testimonialModal = document.getElementById('testimonial_modal');
    const closeTestimonialModal = document.getElementById('close_testimonial_modal');
    const modifyButtons = document.querySelectorAll('.modify_testimonial_button');

    // Gérer le clic sur les boutons Modify
    modifyButtons.forEach(button => {
        button.addEventListener('click', () => {
            const testimonialId = button.getAttribute('data-testimonial-id');
            const offreId = button.getAttribute('data-offre-id');
            const comment = button.closest('tr').querySelector('.testimonial_comment').textContent;

            // Remplir le formulaire
            document.getElementById('commentaire_input').value = comment;
            document.getElementById('testimonial_id_input').value = testimonialId;
            document.getElementById('offre_id_input').value = offreId;

            // Afficher le modal
            testimonialModal.classList.remove('hidden');
        });
    });

    // Fermer le modal avec le bouton X
    closeTestimonialModal.addEventListener('click', () => {
        testimonialModal.classList.add('hidden');
    });

    // Fermer le modal en cliquant en dehors
    window.addEventListener('click', (event) => {
        if (event.target === testimonialModal) {
            testimonialModal.classList.add('hidden');
        }
    });
</script>












<?php require_once(__DIR__.'/../../partials/footer.php');?>