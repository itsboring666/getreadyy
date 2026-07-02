// public/js/admin-modals.js

/** Carousel Modals */
const CarouselModal = {
    toggle() {
        const modal = document.getElementById('carouselModal');
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
        reInitAOS();
    },
    toggleEdit() {
        const modal = document.getElementById('editCarouselModal');
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
        reInitAOS();
    },
    openEdit(button) {
        const carousel = JSON.parse(button.getAttribute('data-carousel'));
        document.getElementById('editCarouselForm').action = `${baseUpdateUrl.carousels}/${carousel.id}`;
        document.getElementById('editTitle').value = carousel.title;
        document.getElementById('editDescription').value = carousel.description;
        
        if (document.getElementById('edit_button_text')) document.getElementById('edit_button_text').value = carousel.button_text || '';
        if (document.getElementById('edit_button_link')) document.getElementById('edit_button_link').value = carousel.button_link || '';
        
        const previewEl = document.getElementById('editCarouselImagePreview');
        if (previewEl) {
            if (carousel.image_path) {
                previewEl.src = carousel.image_path.startsWith('http') ? carousel.image_path : "/storage/" + carousel.image_path;
                previewEl.classList.remove('hidden');
            } else {
                previewEl.classList.add('hidden');
                previewEl.src = '';
            }
        }
        
        document.getElementById('editIsActive').checked = !!carousel.is_active;
        this.toggleEdit();
    }
};

/** Category Modals */
const CategoryModal = {
    openAdd() {
        document.getElementById('addCategoryModal').classList.remove('hidden');
    },
    closeAdd() {
        document.getElementById('addCategoryModal').classList.add('hidden');
    },
    openEdit(id, name, slug, status) {
        document.getElementById('editCategoryForm').action = `${baseUpdateUrl.categories}/${id}`;
        document.getElementById('editName').value = name;
        document.getElementById('editStatus').value = status;
        document.getElementById('editCategoryModal').classList.remove('hidden');
    },
    closeEdit() {
        document.getElementById('editCategoryModal').classList.add('hidden');
    }
};

/** Featured Modals */
const FeaturedModal = {
    open() {
        document.getElementById('featuredModal').classList.remove('hidden');
    },
    close() {
        document.getElementById('featuredModal').classList.add('hidden');
    },
    openEdit() {
        document.getElementById('editFeaturedModal').classList.remove('hidden');
    },
    closeEdit() {
        document.getElementById('editFeaturedModal').classList.add('hidden');
    },
    openReplace() {
        alert('Implement replace modal if needed.');
    }
};

/** New Arrival Modals */
const NewArrivalModal = {
    openAdd() {
        document.getElementById('addNewArrivalModal').classList.remove('hidden');
    },
    closeAdd() {
        document.getElementById('addNewArrivalModal').classList.add('hidden');
    },
    openEdit(id, name, description, imageUrl, status, price) {
        const form = document.getElementById('editArrivalForm');
        form.action = `${baseUpdateUrl.arrivals}/${id}`;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_image_preview').src = imageUrl;
        document.getElementById('edit_status').value = status;
        document.getElementById('editPrice').value = price;
        document.getElementById('editNewArrivalModal').classList.remove('hidden');
    },
    closeEdit() {
        document.getElementById('editNewArrivalModal').classList.add('hidden');
    }
};

/** Product Modals */
let sizeIndex = 0;

function addSizeRow(containerId, size = '', origPrice = '', price = '', stock = '') {
    const container = document.getElementById(containerId);
    if (!container) return;

    const div = document.createElement('div');
    div.className = 'flex items-center gap-2 mb-2 size-row';
    div.innerHTML = `
        <input type="text" name="sizes[${sizeIndex}][size]" value="${size}" class="w-1/4 border px-2 py-1 rounded text-sm" placeholder="Size (e.g. 32, M)" required>
        <input type="number" step="0.01" name="sizes[${sizeIndex}][original_price]" value="${origPrice}" class="w-1/4 border px-2 py-1 rounded text-sm" placeholder="Orig Price">
        <input type="number" step="0.01" name="sizes[${sizeIndex}][price]" value="${price}" class="w-1/4 border px-2 py-1 rounded text-sm" placeholder="Disc Price" required>
        <input type="number" name="sizes[${sizeIndex}][stock]" min="0" value="${stock}" class="w-1/5 border px-2 py-1 rounded text-sm" placeholder="Stock" required>
        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 font-bold px-2">&times;</button>
    `;
    container.appendChild(div);
    sizeIndex++;
}

const ProductModal = {
    openAdd() {
        document.getElementById('addProductModal').classList.remove('hidden');
        const container = document.getElementById('addSizeContainer');
        if (container && container.innerHTML.trim() === '') {
            sizeIndex = 0;
            addSizeRow('addSizeContainer'); // add one empty row by default
        }
    },
    closeAdd() {
        document.getElementById('addProductModal').classList.add('hidden');
    },
    openEdit(button) {
        const product = JSON.parse(button.getAttribute('data-product'));
        console.log("Parsed product:", product);

        document.getElementById('editProductModal').classList.remove('hidden');
        document.getElementById('editProductForm').action = `${baseUpdateUrl.products}/${product.id}`;
        document.getElementById('editProductId').value = product.id;
        document.getElementById('editName').value = product.name;
        document.getElementById('editCategoryId').value = product.category_id;
        document.getElementById('description').value = product.description;
        document.getElementById('editStatus').value = product.status;

        const container = document.getElementById('editSizeContainer');
        if (container) {
            container.innerHTML = '';
            sizeIndex = 0;
            if (product.sizes && product.sizes.length > 0) {
                product.sizes.forEach(s => {
                    addSizeRow('editSizeContainer', s.size, s.original_price || '', s.price, s.stock);
                });
            } else {
                addSizeRow('editSizeContainer');
            }
        }

        const baseStorageUrl = "/storage/";
        const imageKeys = ['image', 'image_2', 'image_3', 'image_4'];
        imageKeys.forEach((key, index) => {
            const previewId = index === 0 ? 'editImagePreview' : `editImage${index + 1}Preview`;
            const previewEl = document.getElementById(previewId);
            if (previewEl) {
                if (product[key]) {
                    previewEl.src = product[key].startsWith('http') ? product[key] : baseStorageUrl + product[key];
                    previewEl.classList.remove('hidden');
                } else {
                    previewEl.classList.add('hidden');
                    previewEl.src = '';
                }
            }
        });
    },
    closeEdit() {
        document.getElementById('editProductModal').classList.add('hidden');
    }
};

/** Global Helpers */
function reInitAOS() {
    setTimeout(() => AOS.init({ once: true, duration: 600 }), 100);
}

/** Optional: Close modals when clicking outside */
window.addEventListener('click', function (e) {
    const modals = ['addNewArrivalModal', 'editNewArrivalModal'];
    modals.forEach(id => {
        const modal = document.getElementById(id);
        if (modal && e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});
