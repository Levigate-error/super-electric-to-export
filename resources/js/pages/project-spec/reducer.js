"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
function reducer(state, { type, payload }) {
    switch (type) {
        case "fetch":
            return Object.assign({}, state, { isLoading: true });
        case "set-section-name":
            return Object.assign({}, state, { sectionName: payload });
        case "set-spec-sections":
            return Object.assign({}, state, { specSections: payload, isLoading: false });
        case "enable-left-affix":
            return Object.assign({}, state, { leftAffix: true });
        case "disable-left-affix":
            return Object.assign({}, state, { leftAffix: false });
        case "open-upload-modal":
            return Object.assign({}, state, { uploadModalIsOpen: true });
        case "close-upload-modal":
            return Object.assign({}, state, { uploadModalIsOpen: false });
        case "spec-prepare-to-download":
            return Object.assign({}, state, { specPrepare: true });
        case "open-download-modal":
            return Object.assign({}, state, { downloadModalIsOpen: true, downloadLink: payload, specPrepare: false });
        case "close-download-modal":
            return Object.assign({}, state, { downloadModalIsOpen: false });
        case "set-project-price":
            return Object.assign({}, state, { totalPrice: payload });
        default:
            return state;
    }
}
exports.reducer = reducer;
