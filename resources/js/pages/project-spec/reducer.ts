export function reducer(state, { type, payload }: any) {
    switch (type) {
        case "fetch":
            return { ...state, isLoading: true };
        case "set-section-name":
            return { ...state, sectionName: payload };
        case "set-spec-sections":
            return { ...state, specSections: payload, isLoading: false };
        case "enable-left-affix":
            return { ...state, leftAffix: true };
        case "disable-left-affix":
            return { ...state, leftAffix: false };
        case "open-upload-modal":
            return { ...state, uploadModalIsOpen: true };
        case "close-upload-modal":
            return { ...state, uploadModalIsOpen: false };
        case "spec-prepare-to-download":
            return {
                ...state,
                specPrepare: true
            };
        case "open-download-modal":
            return {
                ...state,
                downloadModalIsOpen: true,
                downloadLink: payload,
                specPrepare: false
            };
        case "close-download-modal":
            return { ...state, downloadModalIsOpen: false };
        case "set-project-price":
            return { ...state, totalPrice: payload };
        default:
            return state;
    }
}
