"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Icons_1 = require("../../../ui/Icons/Icons");
const Modal_1 = require("../../../ui/Modal/Modal");
const helper_1 = require("./helper");
const moment = require("moment");
const VideoItem = ({ item }) => {
    const [modalIsVisible, setModalVisibility] = React.useState(false);
    const handleOpenVideoModal = () => setModalVisibility(true);
    const handleCloseModal = () => setModalVisibility(false);
    const imgBackgroundStyle = {
        backgroundImage: React.useMemo(() => helper_1.getPreviewImage(item.video), [item.video]),
    };
    return (React.createElement("div", { className: "col-auto mb-3" },
        modalIsVisible && (React.createElement(Modal_1.default, { isOpen: modalIsVisible, onClose: handleCloseModal, hiddenHeader: true },
            React.createElement("iframe", { height: 280, className: "video-list-item-frame", src: item.video, allow: "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture", allowFullScreen: true }))),
        React.createElement("div", { className: "card video-list-item", onClick: handleOpenVideoModal },
            React.createElement("div", { className: "video-list-item-img-wrapper" },
                Icons_1.videoIcon,
                React.createElement("div", { className: "video-list-item-img", style: imgBackgroundStyle })),
            React.createElement("div", { className: "video-list-item-title", onClick: handleOpenVideoModal }, item.title),
            React.createElement("div", { className: "video-list-item-date" }, moment(item.created_at).format('DD.MM.YYYY')))));
};
exports.default = VideoItem;
