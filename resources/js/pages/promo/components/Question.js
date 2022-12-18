"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
const data = [
    {
        question: 'В какой период проходит мотивационная программа «Legrand Inspiria»? ',
        answer: 'Общие сроки проведения Программы - с 01 ноября по 31 декабря 2021 года включительно.',
    },
    {
        question: 'За какой период я могу регистрировать чеки с покупками?',
        answer: 'Покупки оборудования должны быть осуществлены не ранее 01 ноября 2021 и не позднее 31 декабря 2021 года включительно.',
    },
    {
        question: 'Кто может принять участие в Программе?',
        answer: 'В Мотивационной программе могут принять участие лица, постоянно проживающие на территории РФ, полностью дееспособные, достигшие возраста 18 лет (далее по тексту – «Участники»), участвующие в реализации продукции компании «Legrand».',
    },
    {
        question: 'Как зарегистрировать покупку?',
        answer: 'Зарегистрировать чеки с покупкой продукции новой линейки Inspiria можно на сайте https://superelektrik.ru/, путём заполнения соответствующей формы в личном кабинете или загрузки фотографии чека. Также, вы можете отправить чек в чат-боты Telegram/WhatsApp, которые указаны на сайте акции.',
    },
    {
        question: 'Как долго проверяется чек?',
        answer: 'Процесс модерации чека может занимать до 2 рабочих дней. В случае, если информация на чеке будет неразличима или появятся проблемы с проверкой, вы получите соответствующее уведомление в личном кабинете.',
    },
    {
        question: 'Как получить приз?',
        answer: 'При достижении необходимого кол-ва баллов для заказа конкретного приза, участник осуществляет заказ соответствующего приза в личном кабинете на сайте superelektrik.ru. После осуществления заказа приза, данное кол-во баллов считается реализованным и списывается с счёта участника.',
    },
    {
        question: 'Я выиграл приз, когда я его получу?',
        answer: 'Победители Мотивационной программы «Legrand Inspiria» будут уведомлены Оператором о регистрации заказанного приза посредством сообщения в Личном кабинете на сайте superelektrik.ru в течение 5 (пяти) рабочих дней с момента заказа приза. \n\n Призы будут отправлены Организатором или Оператором Программы курьерской/электронной рассылкой в течение 15 (тридцати) рабочих дней с момента направления уведомления о заказе приза и подтверждение Участником данных о почтовом адресе/номере телефона, указанных ранее при регистрации.',
    },
    {
        question: 'У меня ещё остались вопросы, куда я могу обратиться?',
        answer: 'Если, среди данных вопросов, вы не нашли ответ на интересующий вас вопрос, то можете обратиться на почту обратной связи info@legrand-promo.ru ',
    },
];
const Question = () => {
    const [activeButton, setActiveButton] = React.useState(null);
    const [heightContent, setHeightContent] = React.useState(0);
    const handleClick = id => e => {
        const contentPanel = e.target.nextElementSibling;
        setHeightContent(contentPanel.scrollHeight);
        setActiveButton(activeButton === id ? null : id);
    };
    return (React.createElement("div", { className: "promo-question", id: "question" },
        React.createElement("h2", { className: "promo-question__title" }, "\u0412\u043E\u043F\u0440\u043E\u0441\u044B-\u043E\u0442\u0432\u0435\u0442\u044B"),
        React.createElement("div", { className: "promo-question__accordion promo-accordion" }, data.map(({ question, answer }, id) => (React.createElement(React.Fragment, { key: id },
            React.createElement("button", { type: "button", onClick: handleClick(id), className: classnames_1.default('promo-accordion__btn', { active: activeButton === id }) }, question),
            React.createElement("div", { className: "promo-accordion__panel", style: { maxHeight: activeButton === id ? heightContent : 0 } },
                React.createElement("p", { dangerouslySetInnerHTML: { __html: answer } })))))),
        React.createElement("img", { src: "./images/promo/question-img.jpg", alt: "", className: "promo-question__img" })));
};
exports.default = Question;
