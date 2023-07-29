// src/services/apiService.js
import config from "@/config/config";
import axios from "@axios";

// create a new axios instance
const apiClient = axios.create({
    baseURL: config.apiUrl, // use the apiUrl from our config.js
});

export default {
    /**
     * Fetch users data with specified parameters
     * @param {Object} params - Parameters object containing page, limit, and sort
     * @param {Number} params.page - The current page
     * @param {Number} params.limit - The number of items per page (limit)
     * @param {String} params.sort - The sorting order ('asc' or 'desc')
     * @returns {Promise<Object>} The response data
     */
    getUsers: async ({ page, limit, sort }) => {
        try {
            const response = await apiClient.get("users", {
                params: {
                    page,
                    limit,
                    sort,
                },
            });

            console.log(response.data.results);
            console.log(page, limit, sort);

            return response.data; // Access the data
        } catch (error) {
            console.error("Failed to fetch users:", error);
            throw error;
        }
    },

    // Add other API methods as needed...
};
