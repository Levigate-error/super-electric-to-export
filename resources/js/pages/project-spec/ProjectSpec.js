"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const reducer_1 = require("./reducer");
const TabLinks_1 = require("../../ui/TabLinks");
const Specification_1 = require("./components/Specification");
const api_1 = require("./api");
const Icons_1 = require("../../ui/Icons/Icons");
const UploadSpec_1 = require("../../components/UploadSpec");
const PageLayout_1 = require("../../components/PageLayout");
const Input_1 = require("../../ui/Input");
const antd_1 = require("antd");
const Modal_1 = require("../../ui/Modal");
const links = [
    {
        url: '/project/update',
        title: 'Общая информация',
        selected: false,
    },
    {
        url: '/project/products',
        title: 'Добавленная продукция',
        selected: false,
    },
    {
        url: '/project/specifications',
        title: 'Спецификация',
        selected: true,
    },
];
const downloadIconStyle = {
    verticalAlign: 'baseline',
    fontSize: '16px',
    marginRight: 10,
};
function ProjectSpec({ store }) {
    const [{ isLoading, sectionName, specSections, leftAffix, uploadModalIsOpen, downloadModalIsOpen, downloadLink, specPrepare, totalPrice, }, dispatch,] = React.useReducer(reducer_1.reducer, {
        uploadModalIsOpen: false,
        specSections: [],
        sectionName: '',
        isLoading: false,
        leftAffix: true,
        downloadModalIsOpen: false,
        downloadLink: '',
        specPrepare: false,
        totalPrice: store.project.total_price,
    });
    React.useEffect(() => {
        window.addEventListener('resize', resizeWindow);
        checkAffix(window.innerWidth);
        dispatch({ type: 'fetch' });
        updateSpec();
        return () => {
            window.removeEventListener('resize', resizeWindow);
        };
    }, []);
    const checkAffix = width => {
        if (width > 767) {
            dispatch({ type: 'enable-left-affix' });
        }
        else {
            dispatch({ type: 'disable-left-affix' });
        }
    };
    const resizeWindow = e => {
        checkAffix(e.target.innerWidth);
    };
    const openNotificationWithIcon = (type, message, description) => {
        antd_1.notification[type]({
            message,
            description,
        });
    };
    const updateSpec = () => {
        const { specification: { id }, } = store;
        dispatch({ type: 'fetch' });
        api_1.getSpecification(id)
            .then(response => {
            setSections(response.data);
            api_1.updateProjectInfo(store.project.id)
                .then(resp => {
                dispatch({
                    type: 'set-project-price',
                    payload: resp.data.total_price,
                });
            })
                .catch(err => {
                openNotificationWithIcon('error', 'Ошибка получения информации о проекте', '');
            });
        })
            .catch(err => {
            openNotificationWithIcon('error', 'Ошибка получения спецификации', '');
        });
    };
    const setSections = (data) => {
        dispatch({
            type: 'set-spec-sections',
            payload: data,
        });
    };
    const handleDeleteSection = section => {
        const { specification: { id }, } = store;
        api_1.deleteSection(id, section.id).then(response => {
            updateSpec();
            setSections(response.data);
        });
    };
    const handleAddSection = () => {
        dispatch({ type: 'fetch' });
        const { specification: { id }, } = store;
        api_1.addSection(sectionName, id).then(response => {
            dispatch({ type: 'set-section-name', payload: '' });
            updateSpec();
        });
    };
    const handleChangeSectionName = e => dispatch({
        type: 'set-section-name',
        payload: e.target.value,
    });
    const sectionsMenu = (React.createElement(React.Fragment, null,
        React.createElement("ul", { className: "project-spec-list" }, specSections.map(el => (React.createElement("li", { key: el.id || 'fake_section', className: 'project-spec-list-li' },
            React.createElement("span", { className: 'project-spec-list-name' },
                React.createElement("a", { href: `#section-${el.id}`, className: "spec-list-name-link" }, el.title),
                !el.fake_section && (React.createElement("span", { className: "spec-list-icon", onClick: () => handleDeleteSection(el) }, Icons_1.clearIcon))))))),
        React.createElement("div", { className: "proj-spec-add-wrapper" },
            React.createElement(Input_1.default, { onChange: handleChangeSectionName, icon: React.createElement(antd_1.Icon, { type: "plus" }), placeholder: "Добавить раздел", iconAction: handleAddSection, value: sectionName }))));
    const handleOpenUploadModal = () => dispatch({ type: 'open-upload-modal' });
    const handleCloseUploadModal = () => dispatch({ type: 'close-upload-modal' });
    const handleDownloadSpec = () => {
        dispatch({ type: 'spec-prepare-to-download' });
        api_1.downloadSpec(store.project.id).then(response => {
            dispatch({
                type: 'open-download-modal',
                payload: response.data.url,
            });
        });
    };
    const handleCloseDownloadModal = () => dispatch({ type: 'close-download-modal' });
    return (React.createElement("div", { className: "container mt-4 mb-3" },
        React.createElement("div", { className: "row " },
            React.createElement("div", { className: "col-md-10 col-sm-12" },
                React.createElement(TabLinks_1.default, { id: store.project.id, links: links })),
            React.createElement("div", { className: "col-md-2  col-sm-12 upload-download-spec-controls" },
                store.user && React.createElement(UploadSpec_1.default, { isOpen: uploadModalIsOpen, onClose: handleCloseUploadModal }),
                React.createElement(Modal_1.default, { isOpen: downloadModalIsOpen, onClose: handleCloseDownloadModal },
                    React.createElement("a", { href: downloadLink, download: `${store.project.title}_spec.xlsx` },
                        React.createElement(antd_1.Icon, { type: "download", style: downloadIconStyle }),
                        "\u0421\u043A\u0430\u0447\u0430\u0442\u044C \u0441\u043F\u0435\u0446\u0438\u0444\u0438\u043A\u0430\u0446\u0438\u044E")),
                store.user && (React.createElement(antd_1.Tooltip, { title: "Загрузить спецификацию", placement: "bottom" },
                    React.createElement(antd_1.Icon, { type: "upload", onClick: handleOpenUploadModal, className: "icon-control" }))),
                specPrepare ? (React.createElement(antd_1.Icon, { type: "loading", className: "icon-control" })) : (React.createElement(antd_1.Tooltip, { title: "Скачать спецификацию", placement: "bottom" },
                    React.createElement(antd_1.Icon, { type: "download", onClick: handleDownloadSpec, className: "icon-control" }))))),
        React.createElement("div", { className: "row mt-3" },
            React.createElement("div", { className: "col-md-3" }, leftAffix ? React.createElement(antd_1.Affix, { offsetTop: 20, children: sectionsMenu }) : sectionsMenu),
            React.createElement("div", { className: "col-md-9" },
                React.createElement(Specification_1.default, { isLoading: isLoading, sections: specSections, specification: store.specification, setSections: setSections, projectId: store.project.id, updateSpec: updateSpec }))),
        React.createElement("div", { className: "row" },
            React.createElement("div", { className: "col-md-3" }),
            React.createElement("div", { className: "col-md-9 spec-total-wrapper " },
                React.createElement("span", { className: "spec-total-summ-text" }, "\u0418\u0442\u043E\u0433\u043E: "),
                React.createElement("span", { className: "spec-total-summ" },
                    totalPrice,
                    " \u20BD")))));
}
exports.default = PageLayout_1.default(ProjectSpec);
