<?php require_once(__DIR__.'/../../partials/headeruser.php');?>

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
    <div class="container px-6 py-8 mx-auto">
        <h3 class="text-3xl font-medium text-gray-700 mb-10">My Offres</h3>
        <table class="min-w-full text-left">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Title</th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Amount</th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Deadline</th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Status</th>
                    <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase border-b border-gray-200 bg-gray-50"></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <!-- projects -->
                <?php foreach ($offres as $client_offer): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="text-sm font-medium leading-5 text-gray-900"><?= htmlspecialchars($client_offer['titre_projet']); ?></div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="offre_montant text-sm leading-5 text-gray-900 w-full"><?=htmlspecialchars($client_offer['montant']);?></div>
                        </td>

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="offre_deali text-sm leading-5 text-gray-900 w-full"><?= htmlspecialchars($client_offer['delai']); ?></div>
                        </td>

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="text-sm leading-5 text-gray-900 w-full"><?= $client_offer['status']==1?"Pending":($client_offer['status']==2?"Accepted":"Rejected") ?></div>
                        </td>

                        <td class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-b border-gray-200 flex justify-evenly">
                            <!-- accept offre -->
                            <?php if($client_offer['status']!=2){?>
                            <form method="POST" action="/accept_offre" class="mb-0" onsubmit="return confirm('Are you sure you want to accept this offre?');">
                                <input type="hidden" name="id_offre" value="<?= $client_offer['id_offre']; ?>">
                                <button type="submit" name="accept_offre" class="text-indigo-600 hover:text-indigo-900">Accept</button>
                            </form>
                            <?php }?>

                            <!-- add testimonila button -->
                             
                            <?php if($client_offer['status']==2 && !in_array($client_offer['id_offre'], $id_offre_having_testimonial)){?>
                                <button data-offre-id="<?= htmlspecialchars($client_offer['id_offre']); ?>" class="add_testimonial_button text-indigo-600 hover:text-indigo-900">Add Testimonial</button>
                            <?php }?>

                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<div id="testimonial_modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center">
    <div id="modal_content" class="flex flex-col w-11/12 md:w-5/12 overflow-y-auto scrollbar-hidden mx-auto mt-10 p-4 bg-gray-200 rounded-sm shadow-lg">
        <div class="flex justify-between">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl">Testimonial</h1>
            <!-- Close Icon -->
            <button id="close_testimonial_modal" class="flex justify-end items-center mb-4 float-right text-xl">&times;</button>
        </div>
        <!-- Testimonial Form -->
        <form method="POST" action="/addorupdatetesto" id="testimonial_form" class="mt-[25%] md:px-10">
            <!-- Commentaire Field -->
            <div class="flex w-full mb-4">
                <label for="commentaire_input" class="text-gray-900 font-semibold w-1/3">Commentaire:</label>
                <textarea name="commentaire_input" id="commentaire_input" class="w-2/3 border-gray-300 rounded-md p-4" required></textarea>
            </div>

            <!-- Hidden Fields (ID for update) -->
            <input type="text" class="hidden" name="offre_id_input" id="offre_id_input">
            <input type="text" class="hidden" name="testimonial_id_input" id="testimonial_id_input">

            <div class="flex justify-end">
                <input type="submit" name="save_testimonial" class="text-gray-100 bg-gray-700 border-2 border-gray-700 hover:bg-gray-900 px-8 py-1 mt-6 rounded-sm" value="Save">
            </div>
        </form>
    </div>
</div>


<script>
    const testimonialModal = document.getElementById('testimonial_modal');
    const closeTestimonialModal = document.getElementById('close_testimonial_modal');
    const addTestimonialButtons = document.querySelectorAll('.add_testimonial_button'); // Select all add testimonial buttons

    // Show modal for adding a testimonial
    addTestimonialButtons.forEach(addTestimonialButton => {
        addTestimonialButton.onclick = () => {
            showModal();
            document.getElementById('testimonial_form').classList.remove('hidden');
            // Clear fields for adding
            document.getElementById("testimonial_form").reset();            
            document.getElementById('offre_id_input').value = addTestimonialButton.getAttribute('data-offre-id');
        };
    });

    // Show modal for modifying a testimonial
    const modifyTestimonialButtons = document.querySelectorAll('.modify_testimonial_button');

    modifyTestimonialButtons.forEach(modifyTestimonialButton => {
        modifyTestimonialButton.onclick = () => {
            showModal();
            document.getElementById('testimonial_form').classList.remove('hidden');            
                       
            document.getElementById('commentaire_input').value = modifyTestimonialButton.closest("tr").querySelector(".testimonial_comment").textContent;
            document.getElementById('testimonial_id_input').value = modifyTestimonialButton.getAttribute('data-testimonial-id');
            document.getElementById('offre_id_input').value = modifyTestimonialButton.getAttribute('data-offre-id');
        };
    });

    // Close modal when clicking the close button
    closeTestimonialModal.onclick = () => closeModal();

    // Close modal when clicking outside the modal content
    window.addEventListener('click', (event) => {
        if (event.target === testimonialModal) {
            closeModal();
        }
    });

    function showModal() {
        testimonialModal.classList.remove('hidden');
    }

    function closeModal() {
        testimonialModal.classList.add('hidden');
        document.getElementById('testimonial_form').classList.add('hidden');
    }
</script>


<?php require_once(__DIR__.'/../../partials/footer.php');?>