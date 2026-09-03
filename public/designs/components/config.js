/**
 * config.js — shared configuration for all design pages
 *
 * Import this before any page script:
 *   <script src="./components/config.js"></script>
 */

const APP_CONFIG = {

    /**
     * Base URL of the courses API.
     */
    API_BASE_URL: window.location.origin,

    /**
     * Full URL for the courses listing endpoint.
     */
    COURSES_API_URL: window.location.origin + '/api/collab-courses',

    /**
     * Base URL for course cover images.
     */
    IMAGE_BASE_URL: '',

    /**
     * Fallback image when a course has no cover_image.
     */
    IMAGE_FALLBACK: './img/TTT-1.png',

    /**
     * Laravel app base URL.
     */
    APP_URL: window.location.origin,

};
