/**
 * config.js — shared configuration for all design pages
 *
 * Import this before any page script:
 *   <script src="./components/config.js"></script>
 */

const APP_CONFIG = {

    /**
     * Base URL of the courses API.
     * All fetch() calls should use this.
     */
    API_BASE_URL: 'http://devapi.local',

    /**
     * Full URL for the courses listing endpoint.
     */
    COURSES_API_URL: 'http://devapi.local/api/collab-courses',

    /**
     * Base URL for course cover images.
     * cover_image filenames from the API are relative to this path.
     * e.g.  cover_image: "698f0d98e741f1770982808.png"
     * →  http://devcollab.local/assets/images/event/cover/698f0d98e741f1770982808.png
     */
    IMAGE_BASE_URL: 'http://devcollab.local/assets/images/event/cover/',

    /**
     * Fallback image when a course has no cover_image.
     */
    IMAGE_FALLBACK: './img/TTT-1.png',

    /**
     * Laravel app base URL (for cart / checkout).
     */
    APP_URL: 'http://pro.local',

};
