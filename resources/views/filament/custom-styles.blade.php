<style>
    /* -------------------------------------------------------------
       GLOBAL TYPOGRAPHY & BODY STYLING
    ------------------------------------------------------------- */
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap');

    html, body {
        font-family: 'Tajawal', system-ui, -apple-system, sans-serif !important;
        letter-spacing: -0.01em;
        -webkit-font-smoothing: antialiased;
    }

    /* Smooth page scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.02);
    }
    ::-webkit-scrollbar-thumb {
        background: rgba(99, 102, 241, 0.25);
        border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(99, 102, 241, 0.5);
    }

    /* -------------------------------------------------------------
       HEADER & BRAND LOGO
    ------------------------------------------------------------- */
    .fi-logo {
        font-weight: 800 !important;
        font-size: 1.25rem !important;
        letter-spacing: -0.02em;
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 2px 10px rgba(99, 102, 241, 0.15);
    }

    /* -------------------------------------------------------------
       CARDS, WIDGETS & SECTIONS
    ------------------------------------------------------------- */
    .fi-wi-widget,
    .fi-section,
    .fi-ta-ctn,
    .fi-fo-field-wrp-label {
        border-radius: 1rem !important;
    }

    .fi-section,
    .fi-ta-ctn {
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04), 0 2px 6px -1px rgba(0, 0, 0, 0.02) !important;
        border: 1px solid rgba(226, 232, 240, 0.8) !important;
    }

    .dark .fi-section,
    .dark .fi-ta-ctn {
        border-color: rgba(255, 255, 255, 0.08) !important;
    }

    /* Widget hover elevation */
    .fi-wi-stats-overview-stat {
        border-radius: 0.9rem !important;
        border: 1px solid rgba(99, 102, 241, 0.08) !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .fi-wi-stats-overview-stat:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.15) !important;
        border-color: rgba(99, 102, 241, 0.25) !important;
    }

    /* -------------------------------------------------------------
       SIDEBAR & NAVIGATION
    ------------------------------------------------------------- */
    .fi-sidebar-group-label {
        font-weight: 700 !important;
        font-size: 0.75rem !important;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6366f1 !important;
    }

    .fi-sidebar-item-button {
        border-radius: 0.65rem !important;
        font-weight: 600 !important;
        transition: all 0.2s ease !important;
    }

    .fi-sidebar-item-button:hover {
        background-color: rgba(99, 102, 241, 0.08) !important;
    }

    .fi-sidebar-item-active .fi-sidebar-item-button {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3) !important;
    }

    /* -------------------------------------------------------------
       FORM INPUTS & SELECTS
    ------------------------------------------------------------- */
    .fi-input-wrp {
        border-radius: 0.65rem !important;
        transition: all 0.2s ease !important;
    }

    .fi-input-wrp:focus-within {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.18) !important;
    }

    .fi-fo-field-wrp label {
        font-weight: 600 !important;
        font-size: 0.875rem !important;
    }

    /* -------------------------------------------------------------
       BUTTONS & ACTIONS
    ------------------------------------------------------------- */
    .fi-btn {
        border-radius: 0.65rem !important;
        font-weight: 700 !important;
        letter-spacing: -0.01em;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .fi-btn-color-primary {
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.25) !important;
    }

    .fi-btn-color-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.35) !important;
    }

    /* -------------------------------------------------------------
       TABLES, BADGES & PAGINATION
    ------------------------------------------------------------- */
    .fi-ta-header-cell {
        font-weight: 700 !important;
        font-size: 0.8rem !important;
        letter-spacing: 0.03em;

    }

    .fi-ta-row {
        transition: background-color 0.15s ease !important;
    }

    .fi-ta-row:hover {
        background-color: rgba(99, 102, 241, 0.025) !important;
    }

    .fi-badge {
        border-radius: 9999px !important;
        font-weight: 700 !important;
        font-size: 0.75rem !important;
        padding: 0.25rem 0.65rem !important;
    }

    /* -------------------------------------------------------------
       MODALS, NOTIFICATIONS & EMPTY STATES
    ------------------------------------------------------------- */
    .fi-modal-window {
        border-radius: 1.25rem !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
    }

    .fi-no-notification {
        border-radius: 0.85rem !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
    }

    .fi-ta-empty-state {
        padding: 3rem 1.5rem !important;
    }

    .fi-ta-empty-state-icon {
        color: #6366f1 !important;
    }

    /* -------------------------------------------------------------
       AUTH PAGES (LOGIN & REGISTER)
    ------------------------------------------------------------- */
    .fi-simple-layout {
        background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.08), transparent 40%),
                    radial-gradient(circle at bottom left, rgba(168, 85, 247, 0.06), transparent 40%) !important;
    }

    .fi-simple-main {
        border-radius: 1.25rem !important;
        border: 1px solid rgba(226, 232, 240, 0.8) !important;
        box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.08) !important;
    }
</style>
