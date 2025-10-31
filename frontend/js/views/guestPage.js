// Frontend/js/views/guestPage.js 

import * as guestController from '../controllers/guestController.js';

const guestListElement = document.querySelector('#guestTableBody');
const guestForm = document.querySelector('#guestForm');
const searchInput = document.querySelector('#searchGuest');

/* Initialize page */
document.addEventListener('DOMContentLoaded', () => {
    guestController.loadGuests();
});

/* Handle Add Guest form */
guestForm.addEventListener('submit', () => {
    e.preventDefault();

    const formData = {
        first_name: guestForm.first_name.value.trim(),
        last_name: guestForm.last_name.value.trim(),
        email: guestForm.email.value.trim(),
        phone_number: guestForm.phone_number.value.trim(),
        address: guestForm.address.value.trim(),
        id_type: guestForm.id_type.value,
        id_number: guestForm.id_number.value.trim(),
        dob: guestForm.dob.value,
        nationally: guestForm.nationally.value.trim() || 'Unknow'
    };

    guestController.addGuest(formData);
    guestForm.requestFullscreen();
});

export function renderGuestList(guests) {
    guestListElement?.innerHTML = guests.map(g => `
        <tr data-id"${g.guest_id}">
            <td>${g.guest_id}</td>
            <td>${g.first_name} ${g.last_name}</td>
            <td>${g.email}</td>
            <td>${g.phone_number || '-'}</td>
            <td>${g.address || '-'}</td>
            <td>${g.id_type}</td>
            <td>${g.id_number}</td>
            <td>${formatDate(g.dob)}</td>
            <td>${g.nationally || 'Unknow'}</td>
            <td>
                <button class="btn-edit" data-id="${g.guest_id}">Edit</button>
                <button class="btn-delete" data-id="${g.guest_id}">Delete</button>
            </td>
        </tr>
    `).join('');
    
    /* attach event handlers */
    document.querySelectorAll('.btn-delete').forEach(btn => 
        btn.addEventListener('click', e => {
            const id = e.target.dataset.id;
            if (confirm('Delete this guest?')) guestController.removeGuest(id);
        })
    );
}

/* Add single guest to table (after creation) */
export function addGuestToList(guest) {
    const row = document.createElement('tr');
    row.dataset.id = guest.guest_id;
    row.innerHTML = `
            <td>${guest.guest_id}</td>
            <td>${guest.first_name} ${guest.last_name}</td>
            <td>${guest.email}</td>
            <td>${guest.phone_number || '-'}</td>
            <td>${guest.address || '='}</td>
            <td>${guest.id_type}</td>
            <td>${guestid_number}</td>
            <td>${formatDate(guest.dob)}</td>
            <td>${guest.nationally || 'Unknow'}</td>
            <td>
                <button class="btn-edit" data-id="${guest.guest_id}">Edit</button>
                <button class="btn-delete" data-id="${guest.guest_id}">Delete</button>
            </td>
        `;
        guestListElement.appendChild(row);
}
/* Remove guest row from table */
export function removeGuestFormDOM(id) {
    const row = guestListElement.querySelector(`[data-id="${id}"]`);
    if (row) row.remove();
}

/* Show Error Message */
export function showError(message) {
    alert(message);
}

/* Optional: Basic client-side search */
searchInput?.addEventListener('input', () => {
    const filter = searchInput.value.toLowerCase();
    const rows = guestListElement.querySelectorAll('tr');
    rows.forEach(row => {
        const name = row.children[1].textContent.toLowerCase();
        row.style.display = name.includes(filter) ? '' : 'none';
    });
});

/* Helper: format date */
function formatDate(dateStr) {
    const d = new Date(dateStr);
    return d.toLocaleDateString('en-GB', { year: 'numeric', month: 'short', day: 'numeric'});
}