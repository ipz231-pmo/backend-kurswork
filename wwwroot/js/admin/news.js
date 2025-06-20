
const createForm = document.getElementById('create-news-form');

createForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    await createNewsItem();
});

async function createNewsItem(){
    const btn = createForm.querySelector('button[type="submit"]');
    btn.disabled = true;

    const body = {
        title: document.getElementById('create-title').value,
        shortText: document.getElementById('create-shortText').value,
        text: document.getElementById('create-text').value,
    };

    try {
        const response = await fetch('/admin/createNewsAsync', {
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
const tableBody = document.getElementById('news-table-body');


tableBody.querySelectorAll('.update-news-form').forEach(form => {
    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const btn = tableBody.querySelector('button[type="submit"]');
        btn.disabled = true;

        const formData = new FormData(e.target);
        const body = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('/admin/updateNewsAsync', {
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
            const response = await fetch('/admin/deleteNewsAsync', {
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
