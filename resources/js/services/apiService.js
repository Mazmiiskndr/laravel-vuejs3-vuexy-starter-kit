// src/services/apiService.js
import config from "@/config/config";
import axios from "@axios";

// create a new axios instance
const apiClient = axios.create({
    baseURL: config.apiUrl, // use the apiUrl from our config.js
});

export default {
    getUsers: async () => {
        try {
            const response = await apiClient.get("users");

            return response.data; // Access the data
        } catch (error) {
            console.error("Failed to fetch users:", error);
            throw error;
        }
    },

    // Add other API methods as needed...
};
