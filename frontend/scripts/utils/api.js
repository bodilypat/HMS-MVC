/* frontend/scripts/utils/api.js */
export async function fetchRoom() {
	const res = await fetch('api/rooms');
	if (!res.ok) throw new Error('Failed to fetch rooms');
		return res.json();
	}
	
export async function fetchUser() {
	const res = await fetch('/api/user');
	if (!res.ok) throw new Error('No user logged in');
		return res.json();
}
