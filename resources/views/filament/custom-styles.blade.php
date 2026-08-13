<style>
    /* Custom font fallback & smooth typography */
    body {
        font-family: 'Tajawal', system-ui, -apple-system, sans-serif !important;
        letter-spacing: -0.01em;
    }

    /* Polished Card & Widget Containers */
    .fi-wi-widget,
    .fi-section,
    .fi-ta-ctn {
        border-radius: 1rem !important;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05), 0 2px 6px -1px rgba(0, 0, 0, 0.03) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    /* Hover effect on stats and widgets */
    .fi-wi-stats-overview-stat {
        border-radius: 0.85rem !important;
        transition: all 0.2s ease-in-out;
    }

    .fi-wi-stats-overview-stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -5px rgba(99, 102, 241, 0.12) !important;
    }

    /* Header brand title styling */
    .fi-logo {
        font-weight: 700 !important;
        font-size: 1.25rem !important;
        letter-spacing: -0.02em;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Sidebar nav items refinement */
    .fi-sidebar-item-button {
        border-radius: 0.6rem !important;
        transition: background-color 0.15s ease, color 0.15s ease;
    }

    /* Buttons polish */
    .fi-btn {
        border-radius: 0.6rem !important;
        font-weight: 600 !important;
        transition: all 0.15s ease-in-out !important;
    }

    .fi-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Table headers & rows polish */
    .fi-ta-header-cell {
        font-weight: 700 !important;
        text-transform: uppercase;
        font-size: 0.75rem !important;
        letter-spacing: 0.05em;
    }
</style>
