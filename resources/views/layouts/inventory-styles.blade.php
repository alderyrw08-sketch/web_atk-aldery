<style>
    .inventory-page {
        --inv-primary: #006591;
        --inv-accent: #0ea5e9;
        --inv-ink: #131b2e;
        --inv-muted: #667085;
        --inv-border: #e3e8ef;
        --inv-surface: #fff;
        --inv-wash: #f2f4ff;
        --inv-canvas: #f8f9ff;
        --inv-green: #087443;
        --inv-red: #b42318;
        min-height: calc(100vh - 72px);
        padding: 32px 38px;
        background: var(--inv-canvas);
        color: var(--inv-ink);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
    }

    .inventory-page *,
    .inventory-page *::before,
    .inventory-page *::after {
        box-sizing: border-box;
    }

    .inventory-page .inv-heading,
    .inventory-page .inv-page-head,
    .inventory-page .inv-section-head,
    .inventory-page .inv-actions,
    .inventory-page .inv-toolbar,
    .inventory-page .inv-meta,
    .inventory-page .inv-button,
    .inventory-page .inv-icon-button {
        display: flex;
        align-items: center;
    }

    .inventory-page .inv-page-head {
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .inventory-page .inv-heading {
        align-items: flex-start;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .inventory-page .inv-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        color: var(--inv-muted);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .inventory-page .inv-breadcrumb-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--inv-accent);
    }

    .inventory-page .inv-breadcrumb-current {
        color: var(--inv-primary);
    }

    .inventory-page .inv-title {
        margin: 0;
        color: var(--inv-ink);
        font-size: 28px;
        font-weight: 800;
        line-height: 1.25;
    }

    .inventory-page .inv-subtitle {
        margin: 0;
        color: var(--inv-muted);
        font-size: 12px;
        line-height: 1.6;
    }

    .inventory-page .inv-actions {
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 9px;
    }

    .inventory-page .inv-button {
        min-height: 40px;
        justify-content: center;
        gap: 8px;
        padding: 9px 15px;
        border: 1px solid transparent;
        border-radius: 999px;
        background: var(--inv-wash);
        color: var(--inv-ink);
        font: inherit;
        font-weight: 700;
        line-height: 1.2;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        transition: background .16s ease, color .16s ease, border-color .16s ease;
    }

    .inventory-page .inv-button:hover {
        background: #e6eaff;
        color: var(--inv-ink);
    }

    .inventory-page .inv-button-primary {
        background: var(--inv-accent);
        color: #fff;
    }

    .inventory-page .inv-button-primary:hover {
        background: var(--inv-primary);
        color: #fff;
    }

    .inventory-page .inv-button-outline {
        border-color: var(--inv-border);
        background: #fff;
    }

    .inventory-page .inv-button .material-symbols-outlined {
        font-size: 18px;
    }

    .inventory-page .inv-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 20px;
    }

    .inventory-page .inv-stat {
        min-width: 0;
        min-height: 112px;
        justify-content: space-between;
        gap: 12px;
        padding: 18px;
        border: 1px solid var(--inv-border);
        border-radius: 14px;
        background: var(--inv-surface);
        box-shadow: 0 2px 8px rgba(19, 27, 46, .025);
    }

    .inventory-page .inv-stat-label {
        color: var(--inv-muted);
        font-size: 11px;
        font-weight: 600;
    }

    .inventory-page .inv-stat-value {
        margin-top: 5px;
        color: var(--inv-ink);
        font-size: 25px;
        font-weight: 800;
        line-height: 1.2;
    }

    .inventory-page .inv-stat-value small {
        color: var(--inv-muted);
        font-size: 11px;
        font-weight: 500;
    }

    .inventory-page .inv-stat-value.success {
        color: var(--inv-green);
    }

    .inventory-page .inv-stat-value.danger {
        color: var(--inv-red);
    }

    .inventory-page .inv-stat-icon {
        width: 44px;
        height: 44px;
        flex: 0 0 44px;
        justify-content: center;
        border-radius: 50%;
        background: #e1f2ff;
        color: var(--inv-primary);
    }

    .inventory-page .inv-stat-icon.success {
        background: #dcfce7;
        color: var(--inv-green);
    }

    .inventory-page .inv-stat-icon.danger {
        background: #fee4e2;
        color: var(--inv-red);
    }

    .inventory-page .inv-panel,
    .inventory-page .inv-card {
        min-width: 0;
        border: 1px solid var(--inv-border);
        border-radius: 14px;
        background: var(--inv-surface);
        box-shadow: 0 2px 8px rgba(19, 27, 46, .025);
    }

    .inventory-page .inv-panel {
        overflow: hidden;
    }

    .inventory-page .inv-section-head {
        justify-content: space-between;
        gap: 14px;
        padding: 20px 22px 16px;
    }

    .inventory-page .inv-modebar {
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        padding: 12px 16px;
        margin-bottom: 16px;
        border: 1px solid var(--inv-border);
        border-radius: 12px;
        background: #fff;
    }

    .inventory-page .inv-modebar-title {
        display: flex;
        align-items: center;
        gap: 9px;
        color: var(--inv-ink);
        font-size: 12px;
        font-weight: 800;
    }

    .inventory-page .inv-modebar-title .material-symbols-outlined {
        color: var(--inv-accent);
        font-size: 19px;
    }

    .inventory-page .inv-mode-tabs {
        display: inline-flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 4px;
        padding: 4px;
        border-radius: 999px;
        background: var(--inv-wash);
    }

    .inventory-page .inv-mode-tabs a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-height: 34px;
        padding: 7px 13px;
        border-radius: 999px;
        color: var(--inv-muted);
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
    }

    .inventory-page .inv-mode-tabs a:hover {
        background: #fff;
        color: var(--inv-primary);
    }

    .inventory-page .inv-mode-tabs a.active {
        background: var(--inv-accent);
        color: #fff;
    }

    .inventory-page .inv-mode-tabs .material-symbols-outlined {
        font-size: 16px;
    }

    .inventory-page .inv-section-title {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin: 0;
        color: var(--inv-ink);
        font-size: 17px;
        font-weight: 800;
    }

    .inventory-page .inv-count {
        display: inline-flex;
        align-items: center;
        min-height: 23px;
        padding: 3px 9px;
        border-radius: 999px;
        background: #d8efff;
        color: #004c6e;
        font-size: 10px;
        font-weight: 800;
    }

    .inventory-page .inv-toolbar {
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        padding: 12px;
        margin: 0 20px 16px;
        border-radius: 12px;
        background: var(--inv-wash);
    }

    .inventory-page .inv-toolbar-main,
    .inventory-page .inv-toolbar-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .inventory-page .inv-search-wrap {
        position: relative;
        min-width: min(320px, 100%);
        flex: 1 1 260px;
    }

    .inventory-page .inv-search-wrap .material-symbols-outlined {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        color: var(--inv-muted);
        font-size: 19px;
        pointer-events: none;
    }

    .inventory-page .inv-control {
        width: 100%;
        min-height: 40px;
        padding: 8px 12px;
        border: 1px solid transparent;
        border-radius: 9px;
        outline: none;
        background: #fff;
        color: var(--inv-ink);
        font: inherit;
        font-size: 11px;
    }

    .inventory-page .inv-search {
        padding-left: 38px;
    }

    .inventory-page .inv-control:focus {
        border-color: #80c8ee;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, .1);
    }

    .inventory-page .inv-filter {
        width: auto;
        min-width: 145px;
        cursor: pointer;
    }

    .inventory-page .inv-table-wrap {
        width: 100%;
        overflow-x: auto;
        padding: 0 20px;
    }

    .inventory-page table.inv-table {
        width: 100% !important;
        margin: 0 !important;
        border-collapse: separate !important;
        border-spacing: 0;
        color: var(--inv-ink);
        font-family: inherit;
        font-size: 12px;
    }

    .inventory-page .inv-table thead th {
        padding: 13px 12px !important;
        border: 0 !important;
        background: #e9f5ff;
        color: #004c6e;
        font-size: 10px;
        font-weight: 800;
        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .inventory-page .inv-table thead th:first-child {
        border-radius: 9px 0 0 9px;
    }

    .inventory-page .inv-table thead th:last-child {
        border-radius: 0 9px 9px 0;
    }

    .inventory-page .inv-table tbody td {
        padding: 15px 12px !important;
        border: 0 !important;
        border-bottom: 1px solid #edf0f5 !important;
        vertical-align: middle;
    }

    .inventory-page .inv-table tbody tr:nth-child(even) {
        background: rgba(242, 244, 255, .55);
    }

    .inventory-page .inv-table tbody tr:hover {
        background: #f3f7ff;
    }

    .inventory-page .inv-number {
        color: var(--inv-primary);
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .inventory-page .inv-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 10px;
        border-radius: 999px;
        background: #dcfce7;
        color: var(--inv-green);
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .inventory-page .inv-badge.cancelled {
        background: #e9eaf5;
        color: #667085;
    }

    .inventory-page .inv-badge.warning {
        background: #e0f2fe;
        color: #075985;
    }

    .inventory-page .inv-badge.danger {
        background: #fee4e2;
        color: var(--inv-red);
    }

    .inventory-page .inv-row-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-width: 92px;
    }

    .inventory-page .inv-icon-button {
        width: 32px;
        height: 32px;
        flex: 0 0 32px;
        justify-content: center;
        padding: 0;
        border: 0;
        border-radius: 50%;
        background: #dff1ff;
        color: var(--inv-primary);
        text-decoration: none;
        cursor: pointer;
    }

    .inventory-page .inv-icon-button:hover {
        background: #c9e6ff;
    }

    .inventory-page .inv-icon-button.cancel {
        background: #fff0dd;
        color: #b54708;
    }

    .inventory-page .inv-icon-button.delete {
        background: #fee4e2;
        color: var(--inv-red);
    }

    .inventory-page .inv-icon-button .material-symbols-outlined {
        font-size: 17px;
    }

    .inventory-page .inv-table-footer,
    .inventory-page .dataTables_wrapper .row:last-child {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px 20px 18px;
        margin: 0;
    }

    .inventory-page .dataTables_info {
        padding-top: 0 !important;
        color: var(--inv-muted);
        font-size: 11px;
    }

    .inventory-page .dataTables_paginate {
        padding-top: 0 !important;
    }

    .inventory-page .dataTables_paginate .pagination {
        gap: 4px;
        margin: 0 !important;
    }

    .inventory-page .dataTables_paginate .page-link {
        min-width: 34px;
        min-height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0 !important;
        border-radius: 999px !important;
        background: var(--inv-wash);
        color: var(--inv-muted);
        font-size: 11px;
        box-shadow: none !important;
    }

    .inventory-page .dataTables_paginate .page-item.active .page-link {
        background: var(--inv-accent);
        color: #fff;
    }

    .inventory-page .dataTables_length,
    .inventory-page .dataTables_filter {
        display: none;
    }

    .inventory-page .inv-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 15px;
        margin-bottom: 16px;
        border: 1px solid #b7ebc6;
        border-radius: 10px;
        background: #e9fbee;
        color: #087443;
    }

    .inventory-page .inv-alert.error {
        border-color: #fecdca;
        background: #fff1f0;
        color: var(--inv-red);
    }

    .inventory-page .inv-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 300px;
        align-items: start;
        gap: 20px;
    }

    .inventory-page .inv-card {
        padding: 22px;
    }

    .inventory-page .inv-card-accent {
        height: 4px;
        margin: -22px -22px 20px;
        border-radius: 14px 14px 0 0;
        background: #e6bd39;
    }

    .inventory-page .inv-card-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 17px;
        margin-bottom: 18px;
        border-bottom: 1px solid var(--inv-border);
    }

    .inventory-page .inv-card-heading h2,
    .inventory-page .inv-card-heading h3 {
        margin: 0;
        color: var(--inv-ink);
        font-size: 17px;
        font-weight: 800;
    }

    .inventory-page .inv-card-heading .material-symbols-outlined {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #dff1ff;
        color: var(--inv-primary);
        font-size: 21px;
    }

    .inventory-page .inv-form-grid,
    .inventory-page .inv-details-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .inventory-page .inv-field {
        min-width: 0;
    }

    .inventory-page .inv-field.full {
        grid-column: 1 / -1;
    }

    .inventory-page .inv-field label,
    .inventory-page .inv-field-label {
        display: block;
        margin-bottom: 6px;
        color: var(--inv-ink);
        font-size: 11px;
        font-weight: 700;
    }

    .inventory-page .inv-field input,
    .inventory-page .inv-field select,
    .inventory-page .inv-field textarea,
    .inventory-page .inv-input {
        width: 100%;
        min-height: 40px;
        padding: 9px 11px;
        border: 1px solid var(--inv-border);
        border-radius: 8px;
        outline: none;
        background: #fff;
        color: var(--inv-ink);
        font: inherit;
        font-size: 12px;
    }

    .inventory-page .inv-field textarea {
        min-height: 82px;
        resize: vertical;
    }

    .inventory-page .inv-field input:focus,
    .inventory-page .inv-field select:focus,
    .inventory-page .inv-field textarea:focus,
    .inventory-page .inv-input:focus {
        border-color: #80c8ee;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, .1);
    }

    .inventory-page .inv-field .is-invalid {
        border-color: var(--inv-red);
    }

    .inventory-page .inv-error {
        display: block;
        margin-top: 5px;
        color: var(--inv-red);
        font-size: 11px;
        font-weight: 600;
    }

    .inventory-page .inv-item-list {
        display: grid;
        gap: 10px;
        margin: 10px 0 14px;
    }

    .inventory-page .inv-item-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 110px 110px 36px;
        gap: 8px;
        align-items: center;
        padding: 10px;
        border: 1px solid var(--inv-border);
        border-radius: 10px;
        background: #fcfdff;
    }

    .inventory-page .inv-item-row.stock-out-row {
        grid-template-columns: minmax(0, 1fr) 110px 36px;
    }

    .inventory-page .inv-summary {
        padding: 18px;
        border: 1px solid #d6e8f6;
        border-radius: 14px;
        background: linear-gradient(145deg, #eaf6ff, #fff 75%);
    }

    .inventory-page .inv-summary h2 {
        margin: 0 0 14px;
        font-size: 16px;
        font-weight: 800;
    }

    .inventory-page .inv-summary-line {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        padding: 11px 0;
        border-top: 1px solid rgba(0, 101, 145, .12);
        color: var(--inv-muted);
        font-size: 11px;
    }

    .inventory-page .inv-summary-line strong {
        color: var(--inv-primary);
        font-size: 14px;
    }

    .inventory-page .inv-meta-card {
        padding: 12px;
        border-radius: 8px;
        background: var(--inv-wash);
    }

    .inventory-page .inv-meta-card span {
        display: block;
        margin-bottom: 5px;
        color: var(--inv-muted);
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .inventory-page .inv-meta-card strong {
        display: block;
        overflow-wrap: anywhere;
        color: var(--inv-ink);
        font-size: 12px;
        font-weight: 700;
    }

    .inventory-page .inv-table-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding-top: 18px;
        margin-top: 18px;
        border-top: 1px solid var(--inv-border);
    }

    .inventory-confirm-modal .modal-content {
        overflow: hidden;
        border: 1px solid var(--inv-border);
        border-radius: 14px;
        box-shadow: 0 20px 50px rgba(19, 27, 46, .2);
    }

    .inventory-confirm-modal .modal-body {
        padding: 28px 28px 18px;
        text-align: center;
    }

    .inventory-confirm-icon {
        width: 54px;
        height: 54px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        border-radius: 50%;
        background: #fff0dd;
        color: #b54708;
    }

    .inventory-confirm-icon .material-symbols-outlined {
        font-size: 26px;
    }

    .inventory-confirm-modal.is-danger .inventory-confirm-icon {
        background: #fee4e2;
        color: var(--inv-red);
    }

    .inventory-confirm-title {
        margin: 0 0 8px;
        color: var(--inv-ink);
        font-size: 18px;
        font-weight: 800;
    }

    .inventory-confirm-message {
        margin: 0;
        color: var(--inv-muted);
        font-size: 12px;
        line-height: 1.65;
    }

    .inventory-confirm-actions {
        display: flex;
        justify-content: center;
        gap: 9px;
        padding: 0 24px 24px;
    }

    .inventory-confirm-actions .inv-button {
        min-width: 90px;
    }

    .inventory-confirm-modal .inv-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 9px 16px;
        border: 1px solid transparent;
        border-radius: 999px;
        background: #e9eaf5;
        color: var(--inv-ink);
        font: inherit;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .inventory-confirm-modal .inv-button-outline {
        border-color: var(--inv-border);
        background: #fff;
    }

    .inventory-confirm-actions .confirm-submit {
        background: #f59e0b;
        color: #fff;
    }

    .inventory-confirm-modal.is-danger .confirm-submit {
        background: var(--inv-red);
        color: #fff;
    }

    @media (max-width: 1050px) {
        .inventory-page .inv-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .inventory-page .inv-layout {
            grid-template-columns: minmax(0, 1fr);
        }

        .inventory-page .inv-summary {
            order: -1;
        }
    }

    @media (max-width: 700px) {
        .inventory-page {
            padding: 22px 14px;
        }

        .inventory-page .inv-page-head,
        .inventory-page .inv-section-head,
        .inventory-page .inv-modebar {
            align-items: flex-start;
            flex-direction: column;
        }

        .inventory-page .inv-mode-tabs {
            width: 100%;
            overflow-x: auto;
        }

        .inventory-page .inv-title {
            font-size: 24px;
        }

        .inventory-page .inv-actions,
        .inventory-page .inv-actions .inv-button {
            width: 100%;
        }

        .inventory-page .inv-toolbar,
        .inventory-page .inv-toolbar-main,
        .inventory-page .inv-toolbar-actions {
            width: auto;
        }

        .inventory-page .inv-search-wrap {
            min-width: 100%;
        }

        .inventory-page .inv-filter {
            flex: 1 1 135px;
        }

        .inventory-page .inv-table-wrap {
            padding: 0 12px;
        }

        .inventory-page .inv-table-footer,
        .inventory-page .dataTables_wrapper .row:last-child {
            align-items: flex-start;
            flex-direction: column;
            padding: 14px 12px;
        }

        .inventory-page .inv-card {
            padding: 17px;
        }

        .inventory-page .inv-card-accent {
            margin: -17px -17px 18px;
        }

        .inventory-page .inv-item-row,
        .inventory-page .inv-item-row.stock-out-row {
            grid-template-columns: minmax(0, 1fr) 38px;
        }

        .inventory-page .inv-item-row > *:first-child {
            grid-column: 1 / -1;
        }

        .inventory-page .inv-form-grid,
        .inventory-page .inv-details-grid {
            grid-template-columns: minmax(0, 1fr);
        }

        .inventory-page .inv-field.full {
            grid-column: auto;
        }

        .inventory-page .inv-table-actions {
            flex-direction: column-reverse;
        }

        .inventory-page .inv-table-actions .inv-button {
            width: 100%;
        }

        .inventory-confirm-actions {
            flex-direction: column-reverse;
        }

        .inventory-confirm-actions .inv-button {
            width: 100%;
        }
    }

    @media print {
        .inventory-page .inv-actions,
        .inventory-page .inv-toolbar,
        .inventory-page .inv-row-actions,
        .inventory-page .dataTables_paginate {
            display: none !important;
        }
    }
</style>