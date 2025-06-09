const createForm = document.getElementById('create-goods-form');

createForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    await createGoodsItem();
});

async function createGoodsItem(){
    const btn = createForm.querySelector('button[type="submit"]');
    btn.disabled = true;

    const body = {
        name: document.getElementById('create-name').value,
        description: document.getElementById('create-description').value,
        price: document.getElementById('create-price').value,
        imageUrl : document.getElementById('create-imageUrl').value,
    };

    try {
        const response = await fetch('/admin/createGoodsAsync', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(body)
        });
        const result = await response.json();
        alert(result.message);
        if (response.ok) {
            location.reload();
        }
    } catch (error) {
        alert('An error occurred while creating the item.');
        console.error(error);
    } finally {
        btn.disabled = false;
    }
}



// --- Update and Delete Handling (for each row) ---
const tableBody = document.getElementById('goods-table-body');


tableBody.querySelectorAll('.update-goods-form').forEach(form => {
    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const btn = tableBody.querySelector('button[type="submit"]');
        btn.disabled = true;

        const formData = new FormData(e.target);
        const body = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('/admin/updateGoodsAsync', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(body)
            });
            const result = await response.json();
            alert(result.message);
        } catch (error) {
            alert('An error occurred while updating.');
            console.error(error);
        } finally {
            btn.disabled = false;
        }
    });
});

// Delete
tableBody.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', async (e) => {
        if (!confirm('Are you sure you want to delete this item?')) {
            return;
        }

        const btn = e.currentTarget;
        btn.disabled = true;
        const row = btn.closest('tr');
        const id = row.dataset.id;

        try {
            const response = await fetch('/admin/deleteGoodsAsync', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            });
            const result = await response.json();
            alert(result.message);
            if (response.ok) {
                row.remove();
            }
        } catch (error) {
            alert('An error occurred while deleting.');
            console.error(error);
        } finally {
            btn.disabled = false;
        }
    });
});