"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Modal_1 = require("../../../../ui/Modal");
function reducer(state, action) {
    switch (action.type) {
        case 'closeVideo':
            return Object.assign({}, state, { modalIsOpen: false });
        case 'openVideo':
            return Object.assign({}, state, { modalIsOpen: true, selectedVideo: action.payload });
        default:
            throw new Error();
    }
}
function Videos({ videos }) {
    const [state, dispatch] = React.useReducer(reducer, {
        modalIsOpen: false,
        selectedVideo: { videoId: null, description: '' },
    });
    const showMVideo = (videoId, description) => {
        dispatch({ type: 'openVideo', payload: { videoId, description } });
    };
    const closeVideo = () => {
        dispatch({ type: 'closeVideo' });
    };
    const getVideoId = (link) => {
        /*
            exapmle: https://www.youtube.com/watch?v=yBSjKe9EJN8&t=13s
            1. .split('/') => watch?v=yBSjKe9EJN8&t=13s
            2. .split('&') => watch?v=yBSjKe9EJN8
            3. .split('=') => yBSjKe9EJN8
        */
        let splitUrlWithId = link.split('/');
        let idWithParams = splitUrlWithId[splitUrlWithId.length - 1];
        let idWithoutParams = idWithParams.split('&')[0];
        let idWithoutPrefix = idWithoutParams.split('=');
        let idWithoutSuffix = idWithoutPrefix[idWithoutPrefix.length - 1].split('?');
        let id = idWithoutSuffix[0];
        return id;
    };
    return (React.createElement(React.Fragment, null,
        React.createElement("ul", { className: "video-list" },
            React.createElement(Modal_1.default, { isOpen: state.modalIsOpen, onClose: closeVideo, hiddenHeader: true },
                state.modalIsOpen && (React.createElement("iframe", { height: "315", src: `https://www.youtube.com/embed/${state.selectedVideo.videoId}` })),
                React.createElement("span", { className: "video-description" }, state.selectedVideo.description)),
            videos.map((item) => {
                let videoId = getVideoId(item.file_link);
                return (React.createElement("li", { key: item.file_link },
                    React.createElement("button", { className: "video-preview", onClick: () => showMVideo(videoId, item.description) },
                        React.createElement("img", { src: `https://img.youtube.com/vi/${videoId}/sddefault.jpg`, alt: item.description }),
                        React.createElement("span", { className: "video-title" }, item.description))));
            }))));
}
exports.default = React.memo(Videos);
