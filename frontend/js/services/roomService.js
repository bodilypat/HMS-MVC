// Frontend/js/services/roomService.js 

import { apiGet, apiPost, apiPut, apiDelete } from "./api.js";

const ENDPOINT ="/rooms";

export const getRooms = () => apiGet(ENDPOINT);
export const getRoomById = (id) => apiGet(`${ENDPOINT}/${id}`);
export const creatRoom = (roomData) => apiPost(ENDPOINT, roomData);
export const updateRoom = (id, roomData) => apiPut(`${ENDPOINT}/${id}`, roomData);
export const deleteRoom = (id) => apiDelete(`${ENDPOINT}/{id}`);