"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const PageLayout_1 = require("../../components/PageLayout");
const Button_1 = require("../../ui/Button");
const Modal_1 = require("../../ui/Modal");
const Method_1 = require("./components/Modal/Method");
const Manual_1 = require("./components/Modal/Manual");
const Check_1 = require("./components/Modal/Check");
const PrizeConfirm_1 = require("./components/Modal/PrizeConfirm");
const PrizeCheck_1 = require("./components/Modal/PrizeCheck");
const PersonalInfo_1 = require("./components/Modal/PersonalInfo");
const api_1 = require("./api");
const Loyalty = () => {
    const [modalState, setModalState] = React.useState('method');
    const [modalIsOpen, setModalIsOpen] = React.useState(false);
    const [prizePoints, setPrizePoints] = React.useState(0);
    const [tableCollapse, setTableCollapse] = React.useState('loyalty__table--collapse');
    const [uploadedReceipts, setUploadedReceipts] = React.useState([]);
    const [uploadedReceiptsStatus, setUploadedReceiptsStatus] = React.useState(false);
    React.useEffect(() => {
        //console.log('check');
        api_1.getTotalAmount().then(response => {
            //console.log(response);
            setPrizePoints(response);
        });
        api_1.getUploadedReceipts().then(response => {
            setUploadedReceiptsStatus(true);
            setUploadedReceipts(response);
        });
    }, []);
    // const [uploadedReceipts, setUploadedReceipts] = React.useState([
    //     {
    //         fn: 1,
    //         created_at: "Joe",
    //         receipt_datetime: "admin",
    //         review_status: "admin",
    //         lottery_id: "admin"
    //     }
    // ]);
    const RecieptList = props => {
        if (!uploadedReceiptsStatus) {
            return (React.createElement("tr", null,
                React.createElement("td", null, "\u0418\u0434\u0435\u0442 \u0437\u0430\u0433\u0440\u0443\u0437\u043A\u0430 \u0447\u0435\u043A\u043E\u0432")));
        }
        if (!props.reciepts || props.reciepts.length === 0) {
            return (React.createElement("tr", null,
                React.createElement("td", null, "\u041F\u043E\u043A\u0430 \u043D\u0435\u0442 \u0447\u0435\u043A\u043E\u0432. \u0414\u043E\u0431\u0430\u0432\u044C\u0442\u0435 \u0438\u0445.")));
        }
        return props.reciepts.map((reciept, index) => {
            const fn = reciept.fn !== null ? reciept.fn : '-';
            const receipt_datetime = reciept.receipt_datetime !== null ? reciept.receipt_datetime : '-';
            const review_status = reciept.review_status !== null ? reciept.review_status : '-';
            const lottery_id = reciept.lottery_id !== null ? reciept.lottery_id : '-';
            return React.createElement("tr", { key: `reciept_${index}` },
                React.createElement("td", null, lottery_id),
                React.createElement("td", null, receipt_datetime),
                React.createElement("td", null, fn),
                React.createElement("td", null, review_status));
        });
    };
    const toggleTableCollapse = () => {
        if (tableCollapse === 'loyalty__table--collapse') {
            setTableCollapse('');
        }
        else {
            setTableCollapse('loyalty__table--collapse');
        }
    };
    let tableBtnIconClass = tableCollapse === 'loyalty__table--collapse' ? '' : 'loyalty__text-btn__icon--open';
    let tableBtnText = tableCollapse === 'loyalty__table--collapse' ? 'Показать еще' : 'Скрыть';
    const toggleModal = () => {
        setModalIsOpen(!modalIsOpen);
        setModalState('method');
    };
    const toggleModalPrize = (points) => {
        setPrizePoints(points);
        setModalIsOpen(!modalIsOpen);
        setModalState('prize-confirm');
    };
    // console.log('check');
    // getTotalAmount().then(response => {
    //     console.log(response);
    //     setUploadedReceipts(response)
    // });
    return (React.createElement("div", { className: "loayality container mt-5 mb-5" },
        React.createElement(Modal_1.default, { isOpen: modalIsOpen, onClose: toggleModal },
            React.createElement("div", { className: "loyalty__loyalty-modal loyalty-modal pt-4 pb-4" },
                modalState === 'method' && React.createElement(Method_1.default, { setModalState: setModalState }),
                modalState === 'manual' && React.createElement(Manual_1.default, { setModalState: setModalState }),
                modalState === 'personalInfo' && React.createElement(PersonalInfo_1.default, { setModalState: setModalState }),
                modalState === 'check' && React.createElement(Check_1.default, { setModalIsOpen: setModalIsOpen }),
                modalState === 'prize-confirm' &&
                    React.createElement(PrizeConfirm_1.default, { setModalState: setModalState, prizePoints: prizePoints }),
                modalState === 'prize-check' && React.createElement(PrizeCheck_1.default, { setModalIsOpen: setModalIsOpen }))),
        React.createElement("div", { className: "row mt-5 justify-content-between" },
            React.createElement("div", { className: "col-12 col-lg-7" },
                React.createElement("h1", { className: "loyalty__title" }, "\u041F\u0440\u043E\u0433\u0440\u0430\u043C\u043C\u0430 \u043B\u043E\u044F\u043B\u044C\u043D\u043E\u0441\u0442\u0438"),
                React.createElement("p", { className: "loyalty__desc" }, "\u041F\u043E\u043A\u0443\u043F\u0430\u0439 \u043F\u0440\u043E\u0434\u0443\u043A\u0446\u0438\u044E \u0438\u0437 \u043D\u043E\u0432\u043E\u0439 \u043A\u043E\u043B\u043B\u0435\u043A\u0446\u0438\u0438 Inspiria, \u043A\u043E\u043F\u0438 \u0431\u0430\u043B\u043B\u044B \u0438 \u0432\u044B\u0431\u0438\u0440\u0430\u0439 \u0446\u0435\u043D\u043D\u044B\u0435 \u043F\u0440\u0438\u0437\u044B \u043E\u0442 Legrand!"),
                React.createElement(Button_1.default, { value: "Загрузить чек", className: "px-5", onClick: toggleModal })),
            React.createElement("div", { className: "col col-lg-5 col-xl-4" },
                React.createElement("article", { className: "loyalty__info" },
                    React.createElement("header", { className: "loyalty__info__header" },
                        React.createElement("img", { src: "./images/loyalty/superelectric.svg", className: "loyalty__info__img", alt: "Суперэлектрик" }),
                        React.createElement("h2", { className: "loyalty__info__title" },
                            "\u0411\u0430\u043B\u043B\u043E\u0432 \u043D\u0430\u043A\u043E\u043F\u043B\u0435\u043D\u043E",
                            React.createElement("span", { className: "loyalty__info__sum" }, prizePoints))),
                    React.createElement("p", { className: "loyalty__info__desc--grey" }, "\u0420\u0435\u0433\u0438\u0441\u0442\u0440\u0438\u0440\u0443\u0439\u0442\u0435 \u043D\u043E\u0432\u044B\u0435 \u0447\u0435\u043A\u0438 \u0447\u0442\u043E\u0431\u044B \u0437\u0430\u0440\u0430\u0431\u043E\u0442\u0430\u0442\u044C \u0431\u043E\u043B\u044C\u0448\u0435 \u0431\u0430\u043B\u043B\u043E\u0432 \u0438 \u0432\u044B\u0431\u0440\u0430\u0442\u044C \u0441\u0430\u043C\u044B\u0435 \u0446\u0435\u043D\u043D\u044B\u0435 \u043F\u0440\u0438\u0437\u044B")))),
        React.createElement("div", { className: "row mt-4" },
            React.createElement("div", { className: "col-12 col-lg-8" },
                React.createElement("h2", { className: "loyalty__subtitle" }, "\u0417\u0430\u0440\u0435\u0433\u0438\u0441\u0442\u0440\u0438\u0440\u043E\u0432\u0430\u043D\u043D\u044B\u0435 \u0447\u0435\u043A\u0438"),
                React.createElement("table", { className: tableCollapse + ' loyalty__table--checks' },
                    React.createElement("thead", null,
                        React.createElement("tr", null,
                            React.createElement("th", null, "\u2116 \u0447\u0435\u043A\u0430"),
                            React.createElement("th", null, "\u0414\u0430\u0442\u0430 \u0440\u0435\u0433\u0438\u0441\u0442\u0440\u0430\u0446\u0438\u0438"),
                            React.createElement("th", null, "\u0411\u0430\u043B\u043B\u043E\u0432"),
                            React.createElement("th", null, "\u0421\u0442\u0430\u0442\u0443\u0441"))),
                    React.createElement("tbody", null,
                        React.createElement(RecieptList, { reciepts: uploadedReceipts }))),
                React.createElement("button", { onClick: toggleTableCollapse, className: "loyalty__text-btn" },
                    tableBtnText,
                    React.createElement("div", { className: 'loyalty__text-btn__icon ' + tableBtnIconClass })))),
        React.createElement("div", { className: "row mt-4" },
            React.createElement("div", { className: "col-12" },
                React.createElement("h2", { className: "loyalty__subtitle" }, "\u0412\u0438\u0442\u0440\u0438\u043D\u0430 \u043F\u0440\u0438\u0437\u043E\u0432"),
                React.createElement("div", { className: "loyalty__showcase" },
                    React.createElement("div", { className: "loyalty__showcase__item " + (prizePoints >= 25 ? 'loyalty__showcase__item--avaliable' : '') },
                        React.createElement("div", { className: "loyalty__showcase__item--image" },
                            React.createElement("img", { src: "./images/loyalty-program/prize-1.png", alt: "", className: "promo-collection__img" })),
                        React.createElement("h4", null, "\u0424\u0443\u0442\u0431\u043E\u043B\u043A\u0430 Superelektrik"),
                        React.createElement("p", null, "25 \u0431\u0430\u043B\u043B\u043E\u0432"),
                        React.createElement("button", { onClick: () => toggleModalPrize('25'), className: "loyalty__showcase__item--button" }, "\u0412\u044B\u0431\u0440\u0430\u0442\u044C")),
                    React.createElement("div", { className: "loyalty__showcase__item " + (prizePoints >= 50 ? 'loyalty__showcase__item--avaliable' : '') },
                        React.createElement("div", { className: "loyalty__showcase__item--image" },
                            React.createElement("img", { src: "./images/loyalty-program/prize-2.png", alt: "", className: "promo-collection__img" })),
                        React.createElement("h4", null, "\u0417\u0430\u0440\u044F\u0434\u043A\u0430 USB 3in1"),
                        React.createElement("p", null, "50 \u0431\u0430\u043B\u043B\u043E\u0432"),
                        React.createElement("button", { onClick: () => toggleModalPrize('50'), className: "loyalty__showcase__item--button" }, "\u0412\u044B\u0431\u0440\u0430\u0442\u044C")),
                    React.createElement("div", { className: "loyalty__showcase__item " + (prizePoints >= 90 ? 'loyalty__showcase__item--avaliable' : '') },
                        React.createElement("div", { className: "loyalty__showcase__item--image" },
                            React.createElement("img", { src: "./images/loyalty-program/prize-3.png", alt: "", className: "promo-collection__img" })),
                        React.createElement("h4", null, "\u041D\u0430\u0431\u043E\u0440 Quteo IP44"),
                        React.createElement("p", null, "90 \u0431\u0430\u043B\u043B\u043E\u0432"),
                        React.createElement("button", { onClick: () => toggleModalPrize('90'), className: "loyalty__showcase__item--button" }, "\u0412\u044B\u0431\u0440\u0430\u0442\u044C")),
                    React.createElement("div", { className: "loyalty__showcase__item " + (prizePoints >= 100 ? 'loyalty__showcase__item--avaliable' : '') },
                        React.createElement("div", { className: "loyalty__showcase__item--image" },
                            React.createElement("img", { src: "./images/loyalty-program/prize-4.png", alt: "", className: "promo-collection__img" })),
                        React.createElement("h4", null, "\u0411\u0435\u0441\u043F\u0440\u043E\u0432\u043E\u0434\u043D\u0430\u044F \u0437\u0430\u0440\u044F\u0434\u043A\u0430"),
                        React.createElement("p", null, "100 \u0431\u0430\u043B\u043B\u043E\u0432"),
                        React.createElement("button", { onClick: () => toggleModalPrize('100'), className: "loyalty__showcase__item--button" }, "\u0412\u044B\u0431\u0440\u0430\u0442\u044C"),
                        React.createElement("div", { className: "loyalty__showcase__item--help" },
                            React.createElement("svg", { width: "20", height: "20", viewBox: "0 0 20 20", fill: "none", xmlns: "http://www.w3.org/2000/svg" },
                                React.createElement("path", { fillRule: "evenodd", clipRule: "evenodd", d: "M18 10C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10C2 5.58172 5.58172 2 10 2C14.4183 2 18 5.58172 18 10ZM20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10ZM8.48242 10.8848V11.4727H10.5811V11.124C10.5811 10.9281 10.6403 10.7594 10.7588 10.6182C10.8818 10.4723 11.1826 10.2445 11.6611 9.93457C12.2262 9.57454 12.6364 9.19401 12.8916 8.79297C13.1514 8.38737 13.2812 7.90885 13.2812 7.35742C13.2812 6.58724 12.9919 5.97884 12.4131 5.53223C11.8343 5.08561 11.0368 4.8623 10.0205 4.8623C8.78548 4.8623 7.60059 5.18587 6.46582 5.83301L7.41602 7.69238C8.33659 7.20475 9.14095 6.96094 9.8291 6.96094C10.1071 6.96094 10.3327 7.0179 10.5059 7.13184C10.679 7.24121 10.7656 7.3916 10.7656 7.58301C10.7656 7.82454 10.6836 8.03874 10.5195 8.22559C10.36 8.41243 10.0957 8.62207 9.72656 8.85449C9.26172 9.14616 8.93815 9.44694 8.75586 9.75684C8.57357 10.0622 8.48242 10.4382 8.48242 10.8848ZM8.55078 12.8945C8.30925 13.1224 8.18848 13.446 8.18848 13.8652C8.18848 14.2845 8.31608 14.6081 8.57129 14.8359C8.8265 15.0592 9.17969 15.1709 9.63086 15.1709C10.0684 15.1709 10.4124 15.057 10.6631 14.8291C10.9183 14.6012 11.0459 14.2799 11.0459 13.8652C11.0459 13.4505 10.9229 13.1292 10.6768 12.9014C10.4352 12.6689 10.0866 12.5527 9.63086 12.5527C9.1569 12.5527 8.79688 12.6667 8.55078 12.8945Z", fill: "#E60012" })),
                            React.createElement("p", null, "1. \u0420\u043E\u0437\u0435\u0442\u043A\u0438 2 \u0445 2\u041A+\u0417 \u0441 \u0437\u0430\u0449\u0438\u0442\u043D\u044B\u043C\u0438 \u0448\u0442\u043E\u0440\u043A\u0430\u043C\u0438 - IP 44 - 16 A - 250 \u0412~ (\u0446\u0432\u0435\u0442 - \u0431\u0435\u043B\u044B\u0439) 2. \u0412\u044B\u043A\u043B\u044E\u0447\u0430\u0442\u0435\u043B\u044C + 2\u041A+\u0417 \u0440\u043E\u0437\u0435\u0442\u043A\u0430 \u0441 \u0437\u0430\u0449\u0438\u0442\u043D\u044B\u043C\u0438 \u0448\u0442\u043E\u0440\u043A\u0430\u043C\u0438 - IP 44 - 16 A - 250 \u0412~ (\u0446\u0432\u0435\u0442 - \u0431\u0435\u043B\u044B\u0439)"))),
                    React.createElement("div", { className: "loyalty__showcase__item " + (prizePoints >= 100 ? 'loyalty__showcase__item--avaliable' : '') },
                        React.createElement("div", { className: "loyalty__showcase__item--image" },
                            React.createElement("img", { src: "./images/loyalty-program/prize-5.png", alt: "", className: "promo-collection__img" })),
                        React.createElement("h4", null, "\u041D\u0430\u0431\u043E\u0440 \u0430\u0432\u0442\u043E\u043C\u0430\u0442\u043E\u0432 10\u0410 DX3-E "),
                        React.createElement("p", null, "100 \u0431\u0430\u043B\u043B\u043E\u0432"),
                        React.createElement("button", { onClick: () => toggleModalPrize('100'), className: "loyalty__showcase__item--button" }, "\u0412\u044B\u0431\u0440\u0430\u0442\u044C"),
                        React.createElement("div", { className: "loyalty__showcase__item--help" },
                            React.createElement("svg", { width: "20", height: "20", viewBox: "0 0 20 20", fill: "none", xmlns: "http://www.w3.org/2000/svg" },
                                React.createElement("path", { fillRule: "evenodd", clipRule: "evenodd", d: "M18 10C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10C2 5.58172 5.58172 2 10 2C14.4183 2 18 5.58172 18 10ZM20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10ZM8.48242 10.8848V11.4727H10.5811V11.124C10.5811 10.9281 10.6403 10.7594 10.7588 10.6182C10.8818 10.4723 11.1826 10.2445 11.6611 9.93457C12.2262 9.57454 12.6364 9.19401 12.8916 8.79297C13.1514 8.38737 13.2812 7.90885 13.2812 7.35742C13.2812 6.58724 12.9919 5.97884 12.4131 5.53223C11.8343 5.08561 11.0368 4.8623 10.0205 4.8623C8.78548 4.8623 7.60059 5.18587 6.46582 5.83301L7.41602 7.69238C8.33659 7.20475 9.14095 6.96094 9.8291 6.96094C10.1071 6.96094 10.3327 7.0179 10.5059 7.13184C10.679 7.24121 10.7656 7.3916 10.7656 7.58301C10.7656 7.82454 10.6836 8.03874 10.5195 8.22559C10.36 8.41243 10.0957 8.62207 9.72656 8.85449C9.26172 9.14616 8.93815 9.44694 8.75586 9.75684C8.57357 10.0622 8.48242 10.4382 8.48242 10.8848ZM8.55078 12.8945C8.30925 13.1224 8.18848 13.446 8.18848 13.8652C8.18848 14.2845 8.31608 14.6081 8.57129 14.8359C8.8265 15.0592 9.17969 15.1709 9.63086 15.1709C10.0684 15.1709 10.4124 15.057 10.6631 14.8291C10.9183 14.6012 11.0459 14.2799 11.0459 13.8652C11.0459 13.4505 10.9229 13.1292 10.6768 12.9014C10.4352 12.6689 10.0866 12.5527 9.63086 12.5527C9.1569 12.5527 8.79688 12.6667 8.55078 12.8945Z", fill: "#E60012" })),
                            React.createElement("p", null, "1. \u0420\u043E\u0437\u0435\u0442\u043A\u0438 2 \u0445 2\u041A+\u0417 \u0441 \u0437\u0430\u0449\u0438\u0442\u043D\u044B\u043C\u0438 \u0448\u0442\u043E\u0440\u043A\u0430\u043C\u0438 - IP 44 - 16 A - 250 \u0412~ (\u0446\u0432\u0435\u0442 - \u0431\u0435\u043B\u044B\u0439) 2. \u0412\u044B\u043A\u043B\u044E\u0447\u0430\u0442\u0435\u043B\u044C + 2\u041A+\u0417 \u0440\u043E\u0437\u0435\u0442\u043A\u0430 \u0441 \u0437\u0430\u0449\u0438\u0442\u043D\u044B\u043C\u0438 \u0448\u0442\u043E\u0440\u043A\u0430\u043C\u0438 - IP 44 - 16 A - 250 \u0412~ (\u0446\u0432\u0435\u0442 - \u0431\u0435\u043B\u044B\u0439)"))),
                    React.createElement("div", { className: "loyalty__showcase__item " + (prizePoints >= 100 ? 'loyalty__showcase__item--avaliable' : '') },
                        React.createElement("div", { className: "loyalty__showcase__item--image" },
                            React.createElement("img", { src: "./images/loyalty-program/prize-6.png", alt: "", className: "promo-collection__img" })),
                        React.createElement("h4", null, "\u041D\u0430\u0431\u043E\u0440 \u0430\u0432\u0442\u043E\u043C\u0430\u0442\u043E\u0432 16\u0410 DX3-E"),
                        React.createElement("p", null, "100 \u0431\u0430\u043B\u043B\u043E\u0432"),
                        React.createElement("button", { onClick: () => toggleModalPrize('100'), className: "loyalty__showcase__item--button" }, "\u0412\u044B\u0431\u0440\u0430\u0442\u044C"),
                        React.createElement("div", { className: "loyalty__showcase__item--help" },
                            React.createElement("svg", { width: "20", height: "20", viewBox: "0 0 20 20", fill: "none", xmlns: "http://www.w3.org/2000/svg" },
                                React.createElement("path", { fillRule: "evenodd", clipRule: "evenodd", d: "M18 10C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10C2 5.58172 5.58172 2 10 2C14.4183 2 18 5.58172 18 10ZM20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10ZM8.48242 10.8848V11.4727H10.5811V11.124C10.5811 10.9281 10.6403 10.7594 10.7588 10.6182C10.8818 10.4723 11.1826 10.2445 11.6611 9.93457C12.2262 9.57454 12.6364 9.19401 12.8916 8.79297C13.1514 8.38737 13.2812 7.90885 13.2812 7.35742C13.2812 6.58724 12.9919 5.97884 12.4131 5.53223C11.8343 5.08561 11.0368 4.8623 10.0205 4.8623C8.78548 4.8623 7.60059 5.18587 6.46582 5.83301L7.41602 7.69238C8.33659 7.20475 9.14095 6.96094 9.8291 6.96094C10.1071 6.96094 10.3327 7.0179 10.5059 7.13184C10.679 7.24121 10.7656 7.3916 10.7656 7.58301C10.7656 7.82454 10.6836 8.03874 10.5195 8.22559C10.36 8.41243 10.0957 8.62207 9.72656 8.85449C9.26172 9.14616 8.93815 9.44694 8.75586 9.75684C8.57357 10.0622 8.48242 10.4382 8.48242 10.8848ZM8.55078 12.8945C8.30925 13.1224 8.18848 13.446 8.18848 13.8652C8.18848 14.2845 8.31608 14.6081 8.57129 14.8359C8.8265 15.0592 9.17969 15.1709 9.63086 15.1709C10.0684 15.1709 10.4124 15.057 10.6631 14.8291C10.9183 14.6012 11.0459 14.2799 11.0459 13.8652C11.0459 13.4505 10.9229 13.1292 10.6768 12.9014C10.4352 12.6689 10.0866 12.5527 9.63086 12.5527C9.1569 12.5527 8.79688 12.6667 8.55078 12.8945Z", fill: "#E60012" })),
                            React.createElement("p", null, "1. \u0420\u043E\u0437\u0435\u0442\u043A\u0438 2 \u0445 2\u041A+\u0417 \u0441 \u0437\u0430\u0449\u0438\u0442\u043D\u044B\u043C\u0438 \u0448\u0442\u043E\u0440\u043A\u0430\u043C\u0438 - IP 44 - 16 A - 250 \u0412~ (\u0446\u0432\u0435\u0442 - \u0431\u0435\u043B\u044B\u0439) 2. \u0412\u044B\u043A\u043B\u044E\u0447\u0430\u0442\u0435\u043B\u044C + 2\u041A+\u0417 \u0440\u043E\u0437\u0435\u0442\u043A\u0430 \u0441 \u0437\u0430\u0449\u0438\u0442\u043D\u044B\u043C\u0438 \u0448\u0442\u043E\u0440\u043A\u0430\u043C\u0438 - IP 44 - 16 A - 250 \u0412~ (\u0446\u0432\u0435\u0442 - \u0431\u0435\u043B\u044B\u0439)"))),
                    React.createElement("div", { className: "loyalty__showcase__item " + (prizePoints >= 120 ? 'loyalty__showcase__item--avaliable' : '') },
                        React.createElement("div", { className: "loyalty__showcase__item--image" },
                            React.createElement("img", { src: "./images/loyalty-program/prize-7.png", alt: "", className: "promo-collection__img" })),
                        React.createElement("h4", null, "\u041D\u0430\u0431\u043E\u0440 \"Inspiria\""),
                        React.createElement("p", null, "120 \u0431\u0430\u043B\u043B\u043E\u0432"),
                        React.createElement("button", { onClick: () => toggleModalPrize('120'), className: "loyalty__showcase__item--button" }, "\u0412\u044B\u0431\u0440\u0430\u0442\u044C"),
                        React.createElement("div", { className: "loyalty__showcase__item--help" },
                            React.createElement("svg", { width: "20", height: "20", viewBox: "0 0 20 20", fill: "none", xmlns: "http://www.w3.org/2000/svg" },
                                React.createElement("path", { fillRule: "evenodd", clipRule: "evenodd", d: "M18 10C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10C2 5.58172 5.58172 2 10 2C14.4183 2 18 5.58172 18 10ZM20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10ZM8.48242 10.8848V11.4727H10.5811V11.124C10.5811 10.9281 10.6403 10.7594 10.7588 10.6182C10.8818 10.4723 11.1826 10.2445 11.6611 9.93457C12.2262 9.57454 12.6364 9.19401 12.8916 8.79297C13.1514 8.38737 13.2812 7.90885 13.2812 7.35742C13.2812 6.58724 12.9919 5.97884 12.4131 5.53223C11.8343 5.08561 11.0368 4.8623 10.0205 4.8623C8.78548 4.8623 7.60059 5.18587 6.46582 5.83301L7.41602 7.69238C8.33659 7.20475 9.14095 6.96094 9.8291 6.96094C10.1071 6.96094 10.3327 7.0179 10.5059 7.13184C10.679 7.24121 10.7656 7.3916 10.7656 7.58301C10.7656 7.82454 10.6836 8.03874 10.5195 8.22559C10.36 8.41243 10.0957 8.62207 9.72656 8.85449C9.26172 9.14616 8.93815 9.44694 8.75586 9.75684C8.57357 10.0622 8.48242 10.4382 8.48242 10.8848ZM8.55078 12.8945C8.30925 13.1224 8.18848 13.446 8.18848 13.8652C8.18848 14.2845 8.31608 14.6081 8.57129 14.8359C8.8265 15.0592 9.17969 15.1709 9.63086 15.1709C10.0684 15.1709 10.4124 15.057 10.6631 14.8291C10.9183 14.6012 11.0459 14.2799 11.0459 13.8652C11.0459 13.4505 10.9229 13.1292 10.6768 12.9014C10.4352 12.6689 10.0866 12.5527 9.63086 12.5527C9.1569 12.5527 8.79688 12.6667 8.55078 12.8945Z", fill: "#E60012" })),
                            React.createElement("p", null, "1. \u0420\u043E\u0437\u0435\u0442\u043A\u0438 2 \u0445 2\u041A+\u0417 \u0441 \u0437\u0430\u0449\u0438\u0442\u043D\u044B\u043C\u0438 \u0448\u0442\u043E\u0440\u043A\u0430\u043C\u0438 - IP 44 - 16 A - 250 \u0412~ (\u0446\u0432\u0435\u0442 - \u0431\u0435\u043B\u044B\u0439) 2. \u0412\u044B\u043A\u043B\u044E\u0447\u0430\u0442\u0435\u043B\u044C + 2\u041A+\u0417 \u0440\u043E\u0437\u0435\u0442\u043A\u0430 \u0441 \u0437\u0430\u0449\u0438\u0442\u043D\u044B\u043C\u0438 \u0448\u0442\u043E\u0440\u043A\u0430\u043C\u0438 - IP 44 - 16 A - 250 \u0412~ (\u0446\u0432\u0435\u0442 - \u0431\u0435\u043B\u044B\u0439)"))),
                    React.createElement("div", { className: "loyalty__showcase__item " + (prizePoints >= 140 ? 'loyalty__showcase__item--avaliable' : '') },
                        React.createElement("div", { className: "loyalty__showcase__item--image" },
                            React.createElement("img", { src: "./images/loyalty-program/prize-8.png", alt: "", className: "promo-collection__img" })),
                        React.createElement("h4", null, "\u041D\u0430\u0431\u043E\u0440 \"Quteo\""),
                        React.createElement("p", null, "140 \u0431\u0430\u043B\u043B\u043E\u0432"),
                        React.createElement("button", { onClick: () => toggleModalPrize('140'), className: "loyalty__showcase__item--button" }, "\u0412\u044B\u0431\u0440\u0430\u0442\u044C")),
                    React.createElement("div", { className: "loyalty__showcase__item " + (prizePoints >= 160 ? 'loyalty__showcase__item--avaliable' : '') },
                        React.createElement("div", { className: "loyalty__showcase__item--image" },
                            React.createElement("img", { src: "./images/loyalty-program/prize-9.png", alt: "", className: "promo-collection__img" })),
                        React.createElement("h4", null, "\u041D\u0430\u0431\u043E\u0440 \"Valena Life\""),
                        React.createElement("p", null, "160 \u0431\u0430\u043B\u043B\u043E\u0432"),
                        React.createElement("button", { onClick: () => toggleModalPrize('160'), className: "loyalty__showcase__item--button" }, "\u0412\u044B\u0431\u0440\u0430\u0442\u044C")),
                    React.createElement("div", { className: "loyalty__showcase__item " + (prizePoints >= 160 ? 'loyalty__showcase__item--avaliable' : '') },
                        React.createElement("div", { className: "loyalty__showcase__item--image" },
                            React.createElement("img", { src: "./images/loyalty-program/prize-10.png", alt: "", className: "promo-collection__img" })),
                        React.createElement("h4", null, "\u041D\u0430\u0431\u043E\u0440 \"Valena Allure\""),
                        React.createElement("p", null, "160 \u0431\u0430\u043B\u043B\u043E\u0432"),
                        React.createElement("button", { onClick: () => toggleModalPrize('160'), className: "loyalty__showcase__item--button" }, "\u0412\u044B\u0431\u0440\u0430\u0442\u044C")),
                    React.createElement("div", { className: "loyalty__showcase__item " + (prizePoints >= 180 ? 'loyalty__showcase__item--avaliable' : '') },
                        React.createElement("div", { className: "loyalty__showcase__item--image" },
                            React.createElement("img", { src: "./images/loyalty-program/prize-11.png", alt: "", className: "promo-collection__img" })),
                        React.createElement("h4", null, "\u041D\u0430\u0431\u043E\u0440 \"Plexo\""),
                        React.createElement("p", null, "180 \u0431\u0430\u043B\u043B\u043E\u0432"),
                        React.createElement("button", { onClick: () => toggleModalPrize('180'), className: "loyalty__showcase__item--button" }, "\u0412\u044B\u0431\u0440\u0430\u0442\u044C")),
                    React.createElement("div", { className: "loyalty__showcase__item " + (prizePoints >= 200 ? 'loyalty__showcase__item--avaliable' : '') },
                        React.createElement("div", { className: "loyalty__showcase__item--image" },
                            React.createElement("img", { src: "./images/loyalty-program/prize-12.png", alt: "", className: "promo-collection__img" })),
                        React.createElement("h4", null, "\u0414\u0435\u043D\u0435\u0436\u043D\u044B\u0439 \u043F\u0440\u0438\u0437 \u043D\u0430 Qiwi-\u043A\u043E\u0448\u0435\u043B\u0451\u043A"),
                        React.createElement("p", null, "200 \u0431\u0430\u043B\u043B\u043E\u0432"),
                        React.createElement("button", { onClick: () => toggleModalPrize('200'), className: "loyalty__showcase__item--button" }, "\u0412\u044B\u0431\u0440\u0430\u0442\u044C")),
                    React.createElement("div", { className: "loyalty__showcase__item " + (prizePoints >= 250 ? 'loyalty__showcase__item--avaliable' : '') },
                        React.createElement("div", { className: "loyalty__showcase__item--image" },
                            React.createElement("img", { src: "./images/loyalty-program/prize-13.png", alt: "", className: "promo-collection__img" })),
                        React.createElement("h4", null, "\u041D\u0430\u0431\u043E\u0440 \u0443\u043F\u0440\u0430\u0432\u043B\u0435\u043D\u0438\u044F Netatmo \u0431\u0435\u043B\u044B\u0439"),
                        React.createElement("p", null, "250 \u0431\u0430\u043B\u043B\u043E\u0432"),
                        React.createElement("button", { onClick: () => toggleModalPrize('250'), className: "loyalty__showcase__item--button" }, "\u0412\u044B\u0431\u0440\u0430\u0442\u044C")),
                    React.createElement("div", { className: "loyalty__showcase__item " + (prizePoints >= 250 ? 'loyalty__showcase__item--avaliable' : '') },
                        React.createElement("div", { className: "loyalty__showcase__item--image" },
                            React.createElement("img", { src: "./images/loyalty-program/prize-14.png", alt: "", className: "promo-collection__img" })),
                        React.createElement("h4", null, "\u041D\u0430\u0431\u043E\u0440 \u0443\u043F\u0440\u0430\u0432\u043B\u0435\u043D\u0438\u044F Netatmo \u0430\u043B\u044E\u043C\u0438\u043D\u0438\u0439"),
                        React.createElement("p", null, "250 \u0431\u0430\u043B\u043B\u043E\u0432"),
                        React.createElement("button", { onClick: () => toggleModalPrize('250'), className: "loyalty__showcase__item--button" }, "\u0412\u044B\u0431\u0440\u0430\u0442\u044C")),
                    React.createElement("div", { className: "loyalty__showcase__item " + (prizePoints >= 300 ? 'loyalty__showcase__item--avaliable' : '') },
                        React.createElement("div", { className: "loyalty__showcase__item--image" },
                            React.createElement("img", { src: "./images/loyalty-program/prize-15.png", alt: "", className: "promo-collection__img" })),
                        React.createElement("h4", null, "\u0418\u0441\u0442\u043E\u0447\u043D\u0438\u043A \u0431\u0435\u0441\u043F\u0435\u0440\u0435\u0431\u043E\u0439\u043D\u043E\u0433\u043E \u043F\u0438\u0442\u0430\u043D\u0438\u044F"),
                        React.createElement("p", null, "300 \u0431\u0430\u043B\u043B\u043E\u0432"),
                        React.createElement("button", { onClick: () => toggleModalPrize('300'), className: "loyalty__showcase__item--button" }, "\u0412\u044B\u0431\u0440\u0430\u0442\u044C")))))));
};
exports.default = PageLayout_1.default(Loyalty);
